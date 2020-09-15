 <html>
 <head></head>
 <body>
 
 <?php
require_once('app/CompositeEncodingAlgorithm.php');
require_once('app/OffsetEncodingAlgorithm.php');
require_once('app/SubstitutionEncodingAlgorithm.php');
?>

 <?php
/*** CompositeEncodingAlgorithmTest ***/
echo '<h1>CompositeEncodingAlgorithmTest</h1>';

$algorithmA = new App\OffsetEncodingAlgorithm();
$algorithmB = new App\SubstitutionEncodingAlgorithm(['nm','te','x@']);

$valueA = $algorithmA->encode("plain text"); //OffsetEncodingAlgorithm
$valueB = $algorithmB->encode("encoded text"); //SubstitutionEncodingAlgorithm

$algorithm = new App\CompositeEncodingAlgorithm();
$algorithm->add($algorithmA);
$algorithm->add($algorithmB);

$value = $algorithm->encode("plain text"); //CompositeEncodingAlgorithmTest
?>

<table>
	<thead>
		<tr><th>Algo</th><th>Value</th><th>Encoding</th></tr>
	</thead>
	<tbody>
		<tr><td>OffsetEncodingAlgorithm</td><td>plain text</td><td><?php echo $valueA; ?></td></tr>
		<tr><td>SubstitutionEncodingAlgorithm</td><td>encoded text</td><td><?php echo $valueB; ?></td></tr>
		<tr><td>CompositeEncodingAlgorithm</td><td>plain text</td><td><?php echo $value; ?></td></tr>
	</tbody>
</table>

<?php
/*** CompositeOffsetSubstitutionEncodingAlgorithmTest ***/
echo '<h1>CompositeOffsetSubstitutionEncodingAlgorithmTest</h1>';

$substitutions = ['ga', 'de', 'ry', 'po', 'lu', 'ki'];
echo "substitutions: "; print_r($substitutions); echo "<br/><br/>";

$encodings = [
	[0, '', ''],
	[0, 'abc', 'gbc'],
	[1, 'abc', 'bce'],
	[1, 'abc def, ghi.', 'bce dfa, hkj.'],
	[26, 'abc def.', 'GBC EDF.'],
	[26, 'ABC DEF.', 'gbc edf.'],
];
?>

<table>
	<thead>
		<tr><th>Offset</th><th>Text</th><th>Encoding</th><th>Should be</th></tr>
	</thead>
	<tbody>
	
<?php
foreach($encodings as $encoding) {
	$algorithm = new App\CompositeEncodingAlgorithm();

	$algorithm->add(new App\OffsetEncodingAlgorithm($encoding[0]));
	$algorithm->add(new App\SubstitutionEncodingAlgorithm($substitutions));
	
	$value = $algorithm->encode($encoding[1]);
	
	echo '<tr><td>' . $encoding[0] . '</td><td>' . $encoding[1] . '</td><td>' . $value . '</td><td>' . $encoding[2] . '</td></tr>';
}
?>
	</tbody>
</table>

<?php
$encodings = [
    [0, 'abc', 'gbc'],
    [1, 'abc', 'hcd'],
    [1, 'abc def, ghi.', 'hcd feg, bil.'],
];
?>

<br/><br/>

<table>
	<thead>
		<tr><th>Offset</th><th>Text</th><th>Encoding</th><th>Should be</th></tr>
	</thead>
	<tbody>
<?php
foreach($encodings as $encoding) {
	$algorithm = new App\CompositeEncodingAlgorithm();

	$algorithm->add(new App\SubstitutionEncodingAlgorithm($substitutions));
	$algorithm->add(new App\OffsetEncodingAlgorithm($encoding[0]));
	
	$value = $algorithm->encode($encoding[1]);
	
	echo '<tr><td>' . $encoding[0] . '</td><td>' . $encoding[1] . '</td><td>' . $value . '</td><td>' . $encoding[2] . '</td></tr>';
}
?>
	</tbody>
</table>

</body>
<html>

<?php
/*** OffsetEncodingAlgorithmTest ***/
echo '<h1>OffsetEncodingAlgorithmTest</h1>';

$encodings = [
	[0, '', ''],
    [1, '', ''],
    [1, 'a', 'b'],
    [0, 'abc def.', 'abc def.'],
    [1, 'abc def.', 'bcd efg.'],
    [2, 'z', 'B'],
    [1, 'Z', 'a'],
    [26, 'abc def.', 'ABC DEF.'],
    [26, 'ABC DEF.', 'abc def.'],
];
?>

<table>
	<thead>
		<tr><th>Offset</th><th>Text</th><th>Encoding</th><th>Should be</th></tr>
	</thead>
	<tbody>
<?php
foreach($encodings as $encoding) {
	$algorithm = new App\OffsetEncodingAlgorithm($encoding[0]);
	$value     = $algorithm->encode($encoding[1]);
	
	echo '<tr><td>' . $encoding[0] . '</td><td>' . $encoding[1] . '</td><td>' . $value . '</td><td>' . $encoding[2] . '</td></tr>';
}
?>
	</tbody>
</table>

<?php
/*** SubstitutionEncodingAlgorithmTest ***/
echo '<h1>SubstitutionEncodingAlgorithmTest</h1>';

$encodings = [
            [['ab'], 'aabbcc', 'bbaacc'],
            [['ab', 'cd'], 'adam', 'bcbm'],
            [['ga', 'de', 'ry', 'po', 'lu', 'ki'], 'lorem ipsum dolor', 'upydm koslm epupy'],
            [['ga', 'de', 'ry', 'po', 'lu', 'ki'], 'libero euismod bibendum', 'ukbdyp dlksmpe bkbdnelm'],
            [['ga', 'de', 'ry', 'po', 'lu', 'ki'], 'LIBERO EUISMOD BIBENDUM', 'UKBDYP DLKSMPE BKBDNELM'],
            [['GA', 'DE', 'RY', 'PO', 'LU', 'KI'], 'LIBERO EUISMOD BIBENDUM', 'UKBDYP DLKSMPE BKBDNELM'],
];
?>

<table>
	<thead>
		<tr><th>Substitutions</th><th>Text</th><th>Encoding</th><th>Should be</th></tr>
	</thead>
	<tbody>
<?php
foreach($encodings as $encoding) {
	$algorithm = new App\SubstitutionEncodingAlgorithm($encoding[0]);
	$value     = $algorithm->encode($encoding[1]);
	
	echo '<tr><td>'; print_r($encoding[0]); echo '</td><td>' . $encoding[1] . '</td><td>' . $value . '</td><td>' . $encoding[2] . '</td></tr>';
}
?>
	</tbody>
</table>
</body>