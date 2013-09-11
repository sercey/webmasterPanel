<?php
/**
 * Sıralama modülü anasayfası
 */

/// Yeni site ekleme işlemi
if ( isset($_POST['islem']) && $_POST['islem'] == 'siteEkle' ) {
  $kaydedilecek = $webmasterPanel -> ayarOku('siralama_siteler');
  if ( !$kaydedilecek ) // Daha önde hiç site kaydedilmemiş
    $kaydedilecek[] = $_POST['site'];
  else
    $kaydedilecek[] = $_POST['site'];
  $webmasterPanel -> ayarKaydet('siralama_siteler', $kaydedilecek);
}

/// Site silme işlemi
if ( isset($_GET['siteSil']) ) {
  $siteler = $webmasterPanel -> ayarOku('siralama_siteler');
  foreach ( $siteler as $site )
    if ( $site != $_GET['siteSil'] )
      $silindi[] = $site;
  if ( isset($silindi) )
    $webmasterPanel -> ayarKaydet('siralama_siteler', $silindi);
  else
    $webmasterPanel -> ayarSil('siralama_siteler');
}

/// Siteleri listele
$siteler = $webmasterPanel -> ayarOku('siralama_siteler');
if ( $siteler ) {
  echo '<table id="siteler">';
  echo '<tr><th>Site</th><th>PR</th></tr>';
    foreach ( $siteler as $site ) {
      echo '<tr>';
	echo '<td>' . $site . '</td>';
	echo '<td>';
	  echo '<a href="' . siteAdresi . '/modul.php?modul=siralama&PR=' . $site . '">';
	    $pagerank = new GTB_PageRank($site);
	    echo $pagerank->getPageRank();
	  echo '</a>';
	echo '</td>';
	echo '<td><a href="' . siteAdresi . '/modul.php?modul=siralama&siteSil=' . $site . '">Sil</a></td>';
      echo '</tr>';
    }
  echo '</table>';
}

/// Yeni site kaydetme formu
echo '<div class="sutun_100">';
  echo '<h3>Site Ekle</h3>';
  echo '<form method="post" action="' . siteAdresi . '/modul.php?modul=siralama">';
    echo '<input type="hidden" name="islem" value="siteEkle" />';
    echo '<label for="site">Site adresi:</label>';
    echo '<input type="text" name="site" />';
    echo '<input type="submit" value="Ekle" class="button" />';
  echo '</form>';
echo '</div>';
?>