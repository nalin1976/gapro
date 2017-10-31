<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2010 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Writer_Excel5
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.2, 2010-01-11
 */

// Original file header of PEAR::Spreadsheet_Excel_Writer_Workbook (used as the base for this class):
// -----------------------------------------------------------------------------------------
// /*
// *  Module written/ported by Xavier Noguer <xnoguer@rezebra.com>
// *
// *  The majority of this is _NOT_ my code.  I simply ported it from the
// *  PERL Spreadsheet::WriteExcel module.
// *
// *  The author of the Spreadsheet::WriteExcel module is John McNamara 
// *  <jmcnamara@cpan.org>
// *
// *  I _DO_ maintain this code, and John McNamara has nothing to do with the
// *  porting of this code to PHP.  Any questions directly related to this
// *  class library should be directed to me.
// *
// *  License Information:
// *
// *    Spreadsheet_Excel_Writer:  A library for generating Excel Spreadsheets
// *    Copyright (c) 2002-2003 Xavier Noguer xnoguer@rezebra.com
// *
// *    This library is free software; you can redistribute it and/or
// *    modify it under the terms of the GNU Lesser General Public
// *    License as published by the Free Software Foundation; either
// *    version 2.1 of the License, or (at your option) any later version.
// *
// *    This library is distributed in the hope that it will be useful,
// *    but WITHOUT ANY WARRANTY; without even the implied warranty of
// *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
// *    Lesser General Public License for more details.
// *
// *    You should have received a copy of the GNU Lesser General Public
// *    License along with this library; if not, write to the Free Software
// *    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
// */


/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
	/**
	 * @ignore
	 */
	define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../../');
}

/** PHPExcel_Shared_Date */
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/Date.php';

/** PHPExcel_Shared_String */
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/String.php';

/** PHPExcel_Shared_Escher */
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/Escher.php';

/** PHPExcel_Shared_Escher_DggContainer */
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/Escher/DggContainer.php';

/** PHPExcel_Shared_Escher_DggContainer_BstoreContainer */
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/Escher/DggContainer/BstoreContainer.php';

/** PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE */
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/Escher/DggContainer/BstoreContainer/BSE.php';

/** PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE_Blip */
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/Escher/DggContainer/BstoreContainer/BSE/Blip.php';

/** PHPExcel_Worksheet */
require_once PHPEXCEL_ROOT . 'PHPExcel/Worksheet.php';

/** PHPExcel_Writer_Excel5_Xf */
require_once PHPEXCEL_ROOT . 'PHPExcel/Writer/Excel5/Xf.php';

/** PHPExcel_Writer_Excel5_BIFFwriter */
require_once PHPEXCEL_ROOT . 'PHPExcel/Writer/Excel5/BIFFwriter.php';

/** PHPExcel_Writer_Excel5_Worksheet */
require_once PHPEXCEL_ROOT . 'PHPExcel/Writer/Excel5/Worksheet.php';

/** PHPExcel_Writer_Excel5_Font */
require_once PHPEXCEL_ROOT . 'PHPExcel/Writer/Excel5/Font.php';

/** PHPExcel_Writer_Excel5_Escher */
require_once PHPEXCEL_ROOT . 'PHPExcel/Writer/Excel5/Escher.php';


/**
 * PHPExcel_Writer_Excel5_Workbook
 *
 * @category   PHPExcel
 * @package    PHPExcel_Writer_Excel5
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Writer_Excel5_Workbook extends PHPExcel_Writer_Excel5_BIFFwriter
{
	/**
	 * Formula parser
	 *
	 * @var PHPExcel_Writer_Excel5_Parser
	 */
	private $_parser;

	/**
	 * The BIFF file size for the workbook.
	 * @var integer
	 * @see _calcSheetOffsets()
	 */
	var $_biffsize;

	/**
	 * XF Writers
	 * @var PHPExcel_Writer_Excel5_Xf[]
	 */
	private $_xfWriters = array();

	/**
	 * Array containing the colour palette
	 * @var array
	 */
	var $_palette;

	/**
	 * The codepage indicates the text encoding used for strings
	 * @var integer
	 */
	var $_codepage;

	/**
	 * The country code used for localization
	 * @var integer
	 */
	var $_country_code;

	/**
	 * The temporary dir for storing the OLE file
	 * @var string
	 */
	var $_tmp_dir;

	/**
	 * Workbook
	 * @var PHPExcel
	 */
	private $_phpExcel;

	/**
	 * Fonts writers
	 *
	 * @var PHPExcel_Writer_Excel5_Font[]
	 */
	private $_fontWriters = array();

	/**
	 * Added fonts. Maps from font's hash => index in workbook
	 *
	 * @var array
	 */
	private $_addedFonts = array();

	/**
	 * Shared number formats
	 *
	 * @var array
	 */
	private $_numberFormats = array();

	/**
	 * Added number formats. Maps from numberFormat's hash => index in workbook
	 *
	 * @var array
	 */
	private $_addedNumberFormats = array();

	/**
	 * Sizes of the binary worksheet streams
	 *
	 * @var array
	 */
	private $_worksheetSizes = array();

	/**
	 * Offsets of the binary worksheet streams relative to the start of the global workbook stream
	 *
	 * @var array
	 */
	private $_worksheetOffsets = array();

	/**
	 * Total number of shared strings in workbook
	 *
	 * @var int
	 */
	private $_str_total;

	/**
	 * Number of unique shared strings in workbook
	 *
	 * @var int
	 */
	private $_str_unique;

	/**
	 * Array of unique shared strings in workbook
	 *
	 * @var array
	 */
	private $_str_table;

	/**
	 * Color cache
	 */
	private $_colors;


	/**
	 * Class constructor
	 *
	 * @param PHPExcel $phpExcel The Workbook
	 * @param int $BIFF_verions BIFF version
	 * @param int  $str_total		Total number of strings
	 * @param int  $str_unique		Total number of unique strings
	 * @param array  $str_table
	 * @param mixed   $parser	  The formula parser created for the Workbook
	 */
	public function __construct(PHPExcel $phpExcel = null, $BIFF_version = 0x0600,
												&$str_total,
												&$str_unique, &$str_table, &$colors, $parser, $tempDir = ''
								)
	{
		// It needs to call its parent's constructor explicitly
		parent::__construct();

		$this->_parser           = $parser;
		$this->_biffsize         = 0;
		$this->_palette          = array();
		$this->_codepage         = 0x04E4; // FIXME: should change for BIFF8
		$this->_country_code     = -1;

		$this->_str_total       = &$str_total;
		$this->_str_unique      = &$str_unique;
		$this->_str_table       = &$str_table;
		$this->_colors          = &$colors;
		$this->_setPaletteXl97();
		$this->_tmp_dir         = $tempDir;
		
		$this->_phpExcel = $phpExcel;
		
		if ($BIFF_version == 0x0600) {
			$this->_BIFF_version = 0x0600;
			// change BIFFwriter limit for CONTINUE records
			$this->_limit = 8224;
			$this->_codepage = 0x04B0;
		}

		// Add empty sheets
		$countSheets = count($phpExcel->getAllSheets());
		for ($i = 0; $i < $countSheets; ++$i) {
			$phpSheet  = $phpExcel->getSheet($i);
			
			$this->_parser->setExtSheet($phpSheet->getTitle(), $i);  // Register worksheet name with parser

			// for BIFF8
			if ($this->_BIFF_version == 0x0600) {
				$supbook_index = 0x00;
				$ref = pack('vvv', $supbook_index, $i, $i);
				$this->_parser->_references[] = $ref;  // Register reference with parser
			}
		}

		// Build color cache

		// Sheet tab colors?
		$countSheets = count($phpExcel->getAllSheets());
		for ($i = 0; $i < $countSheets; ++$i) {
			$phpSheet  = $phpExcel->getSheet($i);
			if ($phpSheet->isTabColorSet()) {
				$this->_addColor($phpSheet->getTabColor()->getRGB());
			}
		}

	}

	/**
	 * Add a new XF writer
	 *
	 * @param PHPExcel_Style
	 * @param boolean Is it a style XF?
	 * @return int Index to XF record
	 */
	public function addXfWriter($style, $isStyleXf = false)
	{
		$xfWriter = new PHPExcel_Writer_Excel5_Xf($style);
		$xfWriter->setBIFFVersion($this->_BIFF_version);
		$xfWriter->setIsStyleXf($isStyleXf);

		// Add the font if not already added
		$fontHashCode = $style->getFont()->getHashCode();

		if (isset($this->_addedFonts[$fontHashCode])) {
			$fontIndex = $this->_addedFonts[$fontHashCode];
		} else {
			$countFonts = count($this->_fontWriters);
			$fontIndex = ($countFonts < 4) ? $countFonts : $countFonts + 1;

			$fontWriter = new PHPExcel_Writer_Excel5_Font($style->getFont());
			$fontWriter->setBIFFVersion($this->_BIFF_version);
			$fontWriter->setColorIndex($this->_addColor($style->getFont()->getColor()->getRGB()));
			$this->_fontWriters[] = $fontWriter;

			$this->_addedFonts[$fontHashCode] = $fontIndex;
		}

		// Assign the font index to the xf record
		$xfWriter->setFontIndex($fontIndex);

		// Background colors, best to treat these after the font so black will come after white in custom palette
		$xfWriter->setFgColor($this->_addColor($style->getFill()->getStartColor()->getRGB()));
		$xfWriter->setBgColor($this->_addColor($style->getFill()->getEndColor()->getRGB()));
		$xfWriter->setBottomColor($this->_addColor($style->getBorders()->getBottom()->getColor()->getRGB()));
		$xfWriter->setTopColor($this->_addColor($style->getBorders()->getTop()->getColor()->getRGB()));
		$xfWriter->setRightColor($this->_addColor($style->getBorders()->getRight()->getColor()->getRGB()));
		$xfWriter->setLeftColor($this->_addColor($style->getBorders()->getLeft()->getColor()