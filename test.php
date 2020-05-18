<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/40354d1261.js" crossorigin="anonymous"></script>
    <script>
    var state = 1;
    function toggleAll() {
        if (state == 1) {
            $('.Detail').show();
            $('.info').hide();
            $('.close').show();
            state = 0;
            console.log("element shown");
        } else {
            $('.Detail').hide();
            $('.info').show();
            $('.close').hide();
            state = 1;
            console.log("element hidded");
        }
    }

    function toggleThis(id) {
        console.log("toggled " + id);
        $(id + "info").toggle();
        $(id + "close").toggle();
        $(id + "Detail").toggle();
    }
    </script>
</head>

<button onclick="toggleAll()">toggle</button>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th class="DetailNNN">Détails</th>
    </tr>
    <a href=http://Inertie-NAS.synology.me/DBWEB4/DBWEB4_TP4/utilisateurs.php>Users</a>
    <br>
    <tr>
        <td>4017</td>
        <td>2018-06-15</td>
        <td>
            <i class='fa fa-info-circle info 4017info' onclick="toggleThis('.4017')"></i>
            <i class='far fa-times-circle close 4017close' onclick="toggleThis('.4017')" style='display: none;'></i>
            <div class='Detail 4017Detail' style='display: none;'>
                <table border=1>
                	<tr>
                		<th colspan=4>Conserves</th>
                	</tr>
                	<tr>
                		<th>Produit</th>
                		<th>quantité</th>
                		<th>prix unitaire</th>
                		<th>prix</th>
                	</tr>
                	<tr>
                		<td>ratatouille</td>
                		<td>2</td>
                		<td>2.33</td>
                		<td>4.66</td>
                	</tr>
                	<tr>
                		<td>froma</td>
                		<td>2</td>
                		<td>2.3</td>
                		<td>4.6</td>
                	</tr>
                </table>
                <table border=1>
                	<tr>
                		<th rowspan=3>Cat</th>
                	</tr>
                	<tr>
                		<td>Ratatouille</td>
                		<td>2</td>
                		<td>2.33</td>
                		<td>4.66</td>
                	</tr>
                	<tr>
                		<td>Ratatouille</td>
                		<td>2</td>
                		<td>2.33</td>
                		<td>4.66</td>
                	</tr>
                </table>
			</div>
		</td>
	</tr>
</table>
</div>
</td>
</tr>

