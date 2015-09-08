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
	function rendelt_termekek_mentese($nev, $cim, $rendelt_termekek) {
		$rendelesek = fajlbol_betolt('rendelesek.json');
		$rendelesek[] = [
			'nev'    => $nev,
			'cim'    => $cim,
			'termek' => $rendelt_termekek,
			'ido'    => date('Y.m.d. G:i:s'),
		];
		fajlba_ment('rendelesek.json', $rendelesek);
	}
	
	session_start();
	//print_r($_GET);
	//print_r($_POST);

	//beolvasas
	$hibak = [];
	$nev = '';
	$cim = '';
	$kosar = isset($_SESSION['kosar']) 
		? $_SESSION['kosar'] 
		: [];


	if($_POST) {
		$nev = trim($_POST['nev']);
		$cim = trim($_POST['cim']);
		
		if($nev === '') {
			$hibak[] = 'A név megadása kötelező!';
		}
		if($cim === '') {
			$hibak[] = 'A cím megadása kötelező!';
		}

		if(!$hibak) {
			$_SESSION['kosar']=[];
			rendelt_termekek_mentese($nev, $cim, $kosar);
			header('Location: siker.php');
			exit();
		}
	}
 ?>

<!doctype html>
<title>Minishop | Rendelés</title>

<h1>Minishop</h1>
<h2>Termékek</h2>
<h3>Kosár</h3>
<?php if($kosar) : ?>
	<ul>
		<?php foreach ($kosar as $k) : ?>
			<li><?= $k ?></li>
		<?php endforeach; ?>
	</ul>
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
	Név: <input type="text" name="nev" value="<?= $nev ?>"><br>
	Cím: <input type="text" name="cim" value="<?= $cim ?>"><br>
	<input type="submit" name="kosarba">
</form>