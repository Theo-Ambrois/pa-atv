<?php

//Générer une chaîne aléatoire d'une longueur aléatoire entre 6 et 8
//Afficher cette chaîne dans l'image
//	-> avec une police aléatoire par caractère au format ttf se trouvant dans le dossier fonts
//	-> si je rajoute un fichier ttf il doit être automatiquement pris en compte
//	-> avec une position aléatoire par caractère
//	-> avec un angle aléatoire par caractère
//	-> avec une couleur aléatoire par caractère
//	-> avec une taille aléatoire par caractère
//	-> la couleur de fond doit être aléatoire
// 	-> ajouter par dessus une nombre aléatoire de formes géométriques aléatoires de couleurs déjà utilisées par le texte sur des positions aléatoires
//ATTENTION DOIT ÊTRE LISIBLE

session_start();

header("Content-Type: image/png");

$image = imagecreate(400,100);
$length = rand(6,8);

$background = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100));

$letters = "abcdefghijklmnopqrstuvwxyz1234567890";
$letters = str_shuffle($letters);
$captcha = substr($letters, 0, $length);
$_SESSION["captcha"] = $captcha;

$fonts = glob("fonts/*.ttf");

$x = rand(25,50);
$y = rand(40,85);

for($i=0;$i<$length;$i++){
	$size = rand(20, 40);
	$angle = rand(-25, 25);

	$colors[] = imagecolorallocate($image, rand(150,250), rand(150,250), rand(150,250));
	imagettftext($image, $size, $angle, $x, $y, $colors[$i], $fonts[rand(0,count($fonts)-1)] , $captcha[$i]);
	$x += rand(25, 40) ;
	if($y < 25) {
		$y += rand(15,45);
	}elseif($y > 75){
		$y -= rand(15,45);
	}else{
		$y += rand(-15,15);
	}

}

$nb = rand(3,5);

for($i=0; $i<=$nb; $i++ ){

	$j = rand(0,2);

	switch ($j) {
		case 0:
			imageline($image, 0, rand(25, 75), 400, rand(25, 75), $colors[rand(0,count($colors)-1)]);
			break;
		
		case 1:
				imagerectangle($image, rand(100, 300), rand(10, 45), rand(100, 300), rand(55, 90), $colors[rand(0,count($colors)-1)]);
			break;
		
		case 2:
			imageellipse($image, rand(100, 300), rand(25, 75), rand(100, 300), rand(25, 75), $colors[rand(0,count($colors)-1)]);
			break;
	}
}

imagepng($image);