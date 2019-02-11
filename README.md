# Challenge Wordpress

## Ejercicio de Algoritmia

La función devuelve true si el número pasado como argumento es primo; false en caso contrario. Me baso en la definición de número primo como *"aquel que solo es divisible por 1 y por sí mismo"*, es decir, que tiene únicamente 2 divisores:

```PHP
function isPrime($num) {
	$dividers = 0;
	for($n = 1; $n <= $num && $dividers <= 2; $n++){
		if($num % $n === 0)
			$dividers++;
	}
	return $dividers === 2? true : false;
}
```

## Ejercicio de Wordpress

Pasos que he seguido para este ejercicio:
1. He creado un tema hijo a partir del tema **twentysixteen** de Wordpress.
2. En [functions.php](functions.php):
   - He registrado en **after_setup_theme** el custom post type *Cuenta*. Esto yo lo habría hecho en un plugin y no en el tema pero he considerado que así es como se pide en el ejercicio.
   - En **init** he registrado los 2 campos meta para guardar los sumandos de una *Cuenta*
   - En **add_meta_boxes_cuenta** he registrado el formulario que aparecerá al editar una *Cuenta* para poder introducir los sumandos. Este formulario tiene un nonce field para mayor seguridad.
   - En **save_post_cuenta** guardo los sumandos introducidos por el usuario en la tabla **wp_postmeta** de la base de datos
3. Despues he creado la plantilla [single-cuenta.php](single-cuenta.php) que es la que usará WP cuando hacemos click en el permalink de una *Cuenta* concreta. Aquí recupero ambos sumandos de la base de datos y obtengo la suma, cambiando a rojo su color en [style.css](style.css).

No se muy bien a qué se refería con *"entregar un archivo sql con la base de datos"*. No he necesitado crear ninguna tabla adicional.
En cuanto a Vagrant o Docker no los he usado pero se que sirven para crear y/o gestionar máquinas virtuales.

Muchas gracias por su interés y reciba un cordial saludo.

Oscar
