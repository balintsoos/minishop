<?php 
	function fajlba_ment($fajlnev, $adat) {
		$s = json_encode($adat);
		return file_put_contents($fajlnev, $s, LOCK_EX);
	}
	function fajlbol_betolt($fajlnev, $alap = array()) {
		$s = @file_get_contents($fajlnev);
		return ($s === false
			? $alap
			: json_decode($s, true));
	}
	
	$raktar = fajlbol_betolt('termek.json');
	$kategoriak = array_keys($raktar);
 ?>

<!doctype html>
<title>Minishop | Főoldal</title>

<h1>Minishop</h1>

<ul>
	<?php foreach ($kategoriak as $kat) : ?>
		<li>
			<a href="termek.php?kat=<?= $kat ?>">
				<?= $kat ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>