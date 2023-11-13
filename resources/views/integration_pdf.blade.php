<!DOCTYPE html>
<html>
<head>
	<title>Integrasi API</title>
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Dokumentasi Integrasi API</h4>
	</center>
 
     <table class="table" style="width:100%">
        <?php 
            $i = 1;
            foreach ($list as $row) { 
        ?>
        <tr><td height="15">
            <table class="table table-bordered table-striped mb-0" style="width:100%">
                <tr><td height="15">
                    <h4><?php echo $i .'. '. $row->request_name; ?></h4>
                </td></tr>
                <tr><td height="10">
                    <table class="table table-bordered table-striped mb-0" style="width:100%;border: 1px solid black;">
                        <tbody>
                            <tr>
                                <td width="22%">API Url</th>
                                <td width="3%">:</th>
                                <td><?php echo $row->request_url; ?></td>
                            </tr>
                            <tr>
                                <td>Metode</th>
                                <td>:</th>
                                <td><?php echo $row->request_method; ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</th>
                                <td>:</th>
                                <td><?php echo $row->request_description; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td></tr>
                <tr><td height="5">
                    <p>Parameter</p>
                </td></tr>
                <tr><td height="10">
                    <table class="table table-bordered table-striped mb-0" style="width:100%;border: 1px solid black;">
                        <thead>
                            <tr>
                                <th align="left" width="15%" style="border-right: 1px solid black;">Tipe Data</th>
                                <th align="left" width="25%" style="border-right: 1px solid black;">Nilai Awal</th>
                                <th align="left">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $listing = $row->parameter; ?>
                            <?php if(!empty($listing)) { ?>
                            <?php foreach ($listing as $rows) { ?>
                            <tr>
                                <td style="border-right: 1px solid black;border-top: 1px solid black;">{{ $rows->param_type }}</td>
                                <td style="border-right: 1px solid black;border-top: 1px solid black;">{{ $rows->param_initial }}</td>
                                <td style="border-top: 1px solid black;">{{ $rows->param_description }}</td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                                <tr><td align="center" colspan="3" style="border-top: 1px solid black;">
                                    <h5>
                                        Data tidak ditemukan.
                                    </h5>
                                </td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </td></tr>
                <tr><td>&nbsp;</td></tr>
            </table>
        </td></tr>  
        <?php 
                $i = $i + 1;
            } 
        ?>  
    </table>    
</body>
</html>