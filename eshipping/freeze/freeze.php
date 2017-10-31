<html>
<head>
<style type="text/css">
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th {border: 1px solid #999999; padding: 3px 5px; margin:0px;}
.dataTable thead th { background-color:#cccccc; color:#444444; font-weight:bold; text-align:left;}
.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>

<script type="text/javascript" src="jquery-1.2.6.js"></script>
<script type="text/javascript" src="jquery.fixedheader.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$("#data").fixedHeader({
width: 500,height: 300
});
})
</script>


</head>
<body>

<table id="data" class="dataTable">

<thead>
<tr>
<th>1st</th>
<th>2nd</th>
</tr>
</thead>

<tbody>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
<tr>
<td> ….. </td>
<td> ….. </td>
</tr>
</tbody>

</table>

</body>
</html>