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

	session_start();
	//print_r($_GET);
	//print_r($_POST);

	//beolvasas
	$raktar = fajlbol_betolt('termek.json');
	$kat = $_GET['kat'];
	$termekek = $raktar[$kat];
	$kosar = isset($_SESSION['kosar']) 
		? $_SESSION['kosar'] 
		: [];

	$hibak = [];
	$rendelt_termekek = [];

	if($_POST) {
		$rendelt_termekek = isset($_POST['termek'])
			? $_POST['termek']
			: [];
		
		if(!$rendelt_termekek) {
			$hibak[] = 'Válasszon legalább egy terméket!';
		}
		if(!$hibak) {
			$kosar = array_merge($kosar, $rendelt_termekek);
		}
	}

	//kiiras cookieba
	$_SESSION['kosar'] = $kosar;
?>

<!doctype html>
<title>Minishop | Termékek</title>

<h1>Minishop</h1>
<h2>Termékek</h2>
<h3>Kosár</h3>
<?php if($kosar) : ?>
	<ul>
		<?php foreach ($kosar as $k) : ?>
			<li><?= $k ?></li>
		<?php endforeach; ?>
	</ul>
<a href="jovahagy.php">Megrendelés</a>
<?php else : ?>
	<p>A kosár üres!</p>
<?php endif; ?>

<hr>

<?php if($hibak) : ?>
	<ul>
		<?php foreach ($hibak as $hiba) : ?>
			<li><?= $hiba ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<form action="" method="post">
	<?php foreach ($termekek as $t) : ?>
		<input type="checkbox" name="termek[]" value="<?= $t ?>">
		<?= $t ?><br>
	<?php endforeach; ?>
	<input type="submit" name="kosarba">
</form>