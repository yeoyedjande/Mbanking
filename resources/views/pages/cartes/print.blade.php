<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Impression Carte</title>

</head>
<body>
		<br><br>
		<table>
			<tr>
				<td>
					<img width="550" src="data:image/png;base64,{{ base64_encode(file_get_contents( 'https://banking.hopefundburundi.com/assets/images/carte_bancaire/recto.png' )) }}">
				 
                  	<img style="position: absolute; top: 2%; left: 6%; color: gold; padding: 5px;" src="data:image/png;base64,{{ $qrCodeBase64 }}" width="80" alt="QR Code">
                  	<h4 style="position: absolute; top: 10%; left: 20%; color: gold; padding: 5px; font-size: 27px;">{{ $formattedCardNumber }}</h4>
                  	<h4 style="position: absolute; top: 23%; left: 40%; color: gold; padding: 5px;">{{ $expirationDate }}</h4>
                  	<h4 style="position: absolute; top: 27%; left: 10%; color: gold; padding: 5px;">{{ $nom }}</h4>
				</td>
			</tr>
		</table>

</body>
</html>