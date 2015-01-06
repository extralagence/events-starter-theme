<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Document sans nom</title>
</head>

<body>
<center>
<table width="500" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0; border-collapse:collapse; margin: 0px; padding: 0px;">
<tr>


<td colspan="3"><img src="<?php echo home_url("/").'emails/header.png'; ?>" width="500" height="250" alt="Mondial Events" /></td>
</tr>
<tr>
<td width="50"></td>
<td style="font-family:Georgia, serif; font-size: 14px; color: #606060; font-style: normal; line-height: 17px;">
<p>Votre compte a bien été créé sur le site Internet <?php bloginfo(); ?>.</p>
<p><a style="font-family:Georgia, serif; font-size: 14px; color: #00546d; font-style: normal; line-height: 17px;" href="<?php echo get_bloginfo('wpurl').'/wp-login.php'; ?>">Cliquez ici pour vous connecter.</a></p>
<p>
	<ul>
		<li>Nom d'utilisateur : <strong>%username%</strong></li>
		<li>Mot de passe : <strong>%password%</strong></li>
	</ul>
</p>
<p><a style="font-family:Georgia, serif; font-size: 14px; color: #00546d; font-style: normal; line-height: 17px;" href="<?php echo em_get_my_bookings_url(); ?>">Cliquez ici pour voir l'état de votre réservation après vous être connecté</p>
<p>Cordialement,<br>L'équipe MyCorpEvent Demo</p>
</td>
<td width="50"></td>
</tr>
<tr>
<td colspan="3"><img src="<?php echo home_url("/").'emails/bottom.png'; ?>" width="500" height="60" alt="Mondial Events - Copyright 2013" /></td>
</tr>
</table>
</center>
</body>
</html>