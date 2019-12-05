<?php
  #troba depuradores duplicades
  $taula="T_UWWTPS";
  $idNom="uwwCode";//v7
  $where="GROUP BY uwwCode HAVING COUNT(uwwCode)>1";
  $n_pro=$db->querySingle("SELECT SUM(cnt) FROM (SELECT COUNT(*) AS cnt FROM $taula $where)");
  $total_problems+=$n_pro;
?>

<b>
  duplicated uwwtps:
  <span class=n_pro><?php echo $n_pro?></span>
</b>

<table border=1>
  <tr>
    <th>uwwCode
    <th>uwwName
    <th>rptMStateKey
  </tr>
  <?php
    $sql="SELECT * FROM $taula $where";
    $res=$db->query("$sql LIMIT $limit");
    $i=1;while($row=$res->fetchArray(SQLITE3_ASSOC)){
      $obj=(object)$row;

      //busca depuradores duplicades
      $res_2=$db->query("SELECT * FROM $taula WHERE uwwCode='$obj->uwwCode'");
      while($row_2=$res_2->fetchArray(SQLITE3_ASSOC)){
        $obj_2=(object)$row_2;
        echo "<tr>
          <td>".$obj_2->$idNom."
          <td>
            <a target=_blank href='view.php?taula=$taula&idNom=$idNom&idVal=".$obj_2->$idNom."'>
              $obj_2->uwwName
            </a>
          </td>
          <td>$obj_2->rptMStateKey
        ";
      }
      $i++;
    }
    if($i==1){echo "<tr><td colspan=100 class=blank>";}
    echo "<tr><td colspan=100 class=sql>$sql";
  ?>
</table>