<link rel="stylesheet" href ="{TEMPLATES_URL}/css/debugger.css" type="text/css" >
<script language="JavaScript" type="text/javascript">
<!--
function ShowHideDiv (id)
{
	var current_status = document.getElementById(id).style.display;
	if (current_status == 'none')
	{
		document.getElementById(id).style.display = '';
	}
	else 
	{
		document.getElementById(id).style.display = 'none';
	}
}
//-->
</script>
<div class="index_debugger">
	<!-- BEGIN dot_version -->
	<div class="version_zf"><img src="{IMAGES_URL}/debugbar/dotkernel.png" class="debugger_images"><b>{DOT_VERSION}</b></div>
	<!-- END dot_version -->
	<!-- BEGIN zf_version -->
	<div class="version_zf"><img src="{IMAGES_URL}/debugbar/copyright.gif" class="debugger_images"><b>{ZF_VERSION}</b></div>
	<!-- END zf_version -->
	<!-- BEGIN php_version -->
	<div class="version_php"><img src="{IMAGES_URL}/debugbar/php.png" class="debugger_images"><b>{PHP_VERSION}</b></div>
	<!-- END php_version -->
	<!-- BEGIN total_time -->
	<div class="total_time"><img src="{IMAGES_URL}/debugbar/time.png" class="debugger_images"><b>Page generated in</b> : {TOTAL_GENERAL_TIME} ms</div>
	<!-- END total_time -->
	<!-- BEGIN memory_usage -->
	<div class="memory_usage"><img src="{IMAGES_URL}/debugbar/memory.png" class="debugger_images"><b>Memory usage</b> : {MEMORY_USAGE} MB</div>
	<!-- END memory_usage -->
	<!-- BEGIN details_db_debug -->
	<div class="details_debugger_db" onclick="ShowHideDiv('db');"><img src="{IMAGES_URL}/debugbar/database.png" class="debugger_images"><b>Executed queries</b> : {TOTAL_QUERIES}, in {TOTAL_TIME} ms.</div>
	<!-- END details_db_debug -->
	<!-- BEGIN db_debug -->
	<div class="debugger_db"><img src="{IMAGES_URL}/debugbar/database.png" class="debugger_images"><b>Executed queries</b> : {TOTAL_QUERIES}, in {TOTAL_TIME} ms.</div>
	<!-- END db_debug -->

	<!-- BEGIN if_show_debug -->
	<div id="db" style="display: {INITIAL_DISPLAY};" class="db_debug_rows" >
		<table border="0" cellspacing="1" cellpadding="4" class="debugger">
			<tr>
				<th width="70">Query #</th>
				<th>Time</th>
				<th>Query</th>
				<th>Params</th>
			</tr>
			<!-- BEGIN queries -->
			<tr class="{DEBUG_CLASS}">
				<td>{QUERY_COUNT}</td>
				<td>{QUERY_TIME} ms</td>
				<td>{QUERY_TEXT}</td>
				<td align="center">
					<!-- BEGIN if_params --><a onclick="ShowHideDiv('params_{QUERY_COUNT}');">details</a><!-- END if_params -->
					<!-- BEGIN no_params -->No params<!-- END no_params -->
				</td>
			</tr>
			<tr class="{DEBUG_CLASS}_params" id="params_{QUERY_COUNT}" style="display: none;">
				<td valign="top"><b>Params :</b></td>
				<td colspan="3">
					<!-- BEGIN params --><blockquote>{QUERY_PARAMS}</blockquote><!-- END params -->
				</td>
			</tr>
			<!-- END queries -->
		</table><br>
		<table border="0" cellspacing="1" cellpadding="4" class="debugger">
			<tr>
				<td class="debugger_1"><b>Total queries executed</b> : </td>
				<td class="debugger_2">{TOTAL_QUERIES}</td>
			</tr>
			<tr>
				<td class="debugger_1"><b>Total time elapsed</b> : </td>
				<td class="debugger_2">{TOTAL_TIME} ms</td>
			</tr>
			<tr>
				<td class="debugger_1"><b>Average query lenght</b> : </td>
				<td class="debugger_2">{AVERAGE_QUERY_TIME} ms</td>
			</tr>
			<tr>
				<td class="debugger_1"><b>Queries per second</b> : </td>
				<td class="debugger_2">{QUERIES_PER_SECOND} queries</td>
			</tr>
			<tr>
				<td class="debugger_1"><b>Longest query</b> : </td>
				<td class="debugger_2">{LONGEST_QUERY}, in {LONGEST_QUERY_TIME} ms</td>
			</tr>
		</table>
	</div>
	<!-- END if_show_debug -->
</div>