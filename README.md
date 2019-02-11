# Challenge Wordpress

Ejercicio de Algoritmia

La función devuelve true si el número pasado como argumento es primo; false en caso contrario. Me baso en la definición de número primo como "aquel que solo es divisible por 1 y por sí mismo", es decir, que tiene únicamente 2 divisores:

function isPrime($num) {
	$dividers = 0;
	for($n = 1; $n <= $num && $dividers <= 2; $n++){
		if($num % $n === 0)
			$dividers++;
	}
	return $dividers === 2? true : false;
}

Ejercicio de Wordpress

