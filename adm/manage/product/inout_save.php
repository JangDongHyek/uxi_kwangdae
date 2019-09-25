<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include_once "../../inc/oper_info.php"; ?>
<? include_once "../../inc/prd_info.php"; ?>

<?php

if ($mode == "insert") {
    $idx = uniqid().str_pad(rand(0, 99), 2, "0", STR_PAD_LEFT);

    $sql = "
        insert into wiz_product_inout
            (
                idx,
                id, prd_code, prd_name,
                price,
                prd_in, prd_in_description, prd_out, prd_out_description,
                order_idx,
                lender,
                sand_date, return_date, order_date
            )
        values
            (
                '$idx',
                '$id', '$prd_code', '$prd_name',
                '$price',
                '$prd_in', '$prd_in_description', '$prd_out', '$prd_out_description',
                '$order_idx',
                '$lender',
                '$sand_date', '$return_date', '$order_date'
            )
    ";

    mysql_query($sql) or die (mysql_error());

    complete("내역이 입력되었습니다.","inout_input.php?mode=update&idx=$idx");
} elseif ($mode == "update") {

    $search_sql = "";
    $search_sql = "and idx = '$idx'";

    $sql = "
        update wiz_product_inout set
            id = '$id', prd_code = '$prd_code', prd_name = '$prd_name',
            price = '$price',
            prd_in = '$prd_in', prd_in_description = '$prd_in_description', prd_out = '$prd_out', prd_out_description = '$prd_out_description',
            order_idx = '$order_idx',
            lender = '$lender',
            sand_date = '$sand_date', return_date = '$return_date', order_date = '$order_date'
        where
            idx = '$idx'
    ";

    mysql_query($sql) or die (mysql_error());

    complete("내역이 수정되었습니다.","inout_input.php?mode=update&idx=$idx");
} elseif ($mode =="delete") {
    $idx = explode(',',$idx);
    for ($i=0; $i < count($idx); $i++) {
        $sql = "delete from wiz_product_inout where idx = '$idx[$i]' ";

        mysql_query($sql) or die (mysql_error());
    }

    complete("선택한 내역이 삭제되었습니다.","prd_inout.php");
}
 ?>
