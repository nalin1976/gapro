<?php
/**
 * @chinthaka Jayasekara
 * @copyright 2009
 * PDF writting Module
 */
 
require_once(dirname(__FILE__).'/public_html/config.inc.php');
require_once(HTML2PS_DIR.'pipeline.factory.class.php');
error_reporting(E_ALL);
ini_set("display_errors","1");
@set_time_limit(10000);
parse_config_file(HTML2PS_DIR.'html2ps.config');

class MyDestinationFile extends Destination {
  /**
   * @var String result file name / path
   * @access private
   */
  var $_dest_filename;

  function MyDestinationFile($dest_filename) {
    $this->_dest_filename = $dest_filename;
  }

  function process($tmp_filename, $content_type) {
    copy($tmp_filename, $this->_dest_filename);
  }
}

class MyFetcherLocalFile extends Fetcher {
  var $_content;

  function MyFetcherLocalFile($file) {
    $this->_content = file_get_contents($file);
  }

  function get_data($dummy1) {
    return new FetchedDataURL($this->_content, array(), "");
  }

  function get_base_url() {
    return "file:///C:/rac/html2ps/test/";
  }
}
class pdfWriter
{

	function convertToPdf($body,$fileName)
	{

	$path_to_html = "htmlRpt\\".$fileName.".html";
	$fh = fopen($path_to_html, 'w+') or die("can't open file");
	$string_data = "Lorem ipsum";
	fwrite($fh, $body);
	echo "1";
//echo $html_file;
	$path_to_pdf="pdfRpt\\".$fileName.".pdf";
	 $pipeline = PipelineFactory::create_default_pipeline("", // Attempt to auto-detect encoding
                                                       "");
  // Override HTML source 
  $pipeline->fetchers[] = new MyFetcherLocalFile($path_to_html);

  $filter = new PreTreeFilterHeaderFooter("GaPro", "Copyright 2009, California Link (PVT) Ltd.");
 $pipeline->pre_tree_filters[] = $filter;

  // Override destination to local file
  $pipeline->destination = new MyDestinationFile($path_to_pdf);

  $baseurl = "www.google.com";
  $media = Media::predefined("A4");
  $media->set_landscape(false);
  $media->set_margins(array('left'   => 0,
                            'right'  => 0,
                            'top'    => 20,
                            'bottom' => 30));
  $media->set_pixels(1024); 

  global $g_config;
  $g_config = array(
                    'cssmedia'     => 'screen',
                    'scalepoints'  => '1',
                    'renderimages' => true,
                    'renderlinks'  => false,
                    'renderfields' => true,
                    'renderforms'  => false,
                    'mode'         => 'html',
                    'encoding'     => '',
                    'debugbox'     => false,
                    'pdfversion'    => '1.2',
                    'draw_page_border' => false
					
                    );
  $pipeline->configure($g_config);
  $pipeline->add_feature('toc', array('location' => 'before'));
  $pipeline->process($baseurl, $media);

	
	echo "2";

	}

}
?>