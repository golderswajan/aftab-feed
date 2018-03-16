<?php
/**
 * Created by PhpStorm.
 * User: swaja
 * Date: 12/24/2017
 * Time: 10:15 AM
 */

function db_connect(){
    $serverName = "localhost";
    $userName = "aftab";
    $pass = "aftab";
    $dbName = "aftab";

    $con = new mysqli($serverName,$userName,$pass,$dbName);

    if(!$con->connect_error){
        return $con;
    }else {
        die("Error in connection : ".$con->connect_error);
    }
}

function db_select($query){
    $con = db_connect();
    $rows = $con->query($query);
    $data = [];
    if($rows==null){
        echo "database query failed";
    }else {
        $rows = $rows->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row){
            array_push($data,$row);
        }
    }
    $con->close();
    return $data;
}

function db_update($query){
    $con = db_connect();
    $con->query($query);
    $con->close();
    if (!isset($_SESSION))
    {
        session_start();
    }
    $_SESSION['message'] = "Updated Successfully!";
}

function db_delete($query){
    db_update($query);

}

function db_insert($query){
    db_update($query);
    if (!isset($_SESSION))
    {
        session_start();
    }
    $_SESSION['message'] = "Added Successfully!";
}

// sales pages function
function db_insert_get_customer($name){
    $query = "INSERT INTO `customer` (`id`, `name`, `address`) VALUES (NULL, '".$name."', NULL);";
    db_insert($query);
    $query = "select max(id) as id from customer where name='".$name."'";
    $id = db_select($query);
    return $id[0]['id'];

}

function db_insert_get_saleId($total,$comission=0,$net,$customerId,$categoryId,$memoNo){
    $time = time();
    $date = date('Y-m-d',$time);
    $query = "INSERT INTO `sale` (`id`, `total`,`comission`,`net`, `date`, `customerId`, `categoryId`, `memoNo`) VALUES (NULL, '".$total."','".$comission."','".$net."', '".$date."', '".$customerId."', ".$categoryId.", '".$memoNo."')";
    db_insert($query);
    $query = "select max(id) as id from sale where customerId='".$customerId."'";
    $id = db_select($query);

//    increment of memo no
    $query = "select name from category where id ='".$categoryId."'";
    $category = db_select($query)[0]['name'];
    $query = "update memono set ".$category." = ".$category."+1";

    db_update($query);
    return $id[0]['id'];
}

//for returns page
function db_insert_get_returnsId_autoPayment($total,$categoryId,$memo,$autoPayment){
    $time = time();
    $date = date('Y-m-d',$time);
    $query = "INSERT INTO `returns` (`saleId`,`date`,`total`)  SELECT sale.id,'".$date."','".$total."' from sale where sale.categoryId='".$categoryId."' && sale.memoNo='".$memo."';";
    db_insert($query);
    $query = "select max(returns.id) as id from returns where returns.saleId in (select sale.id from sale where sale.categoryId='".$categoryId."' && sale.memoNo='".$memo."')";
    $id = db_select($query);

    if($autoPayment==1){
        $query = "select customer.address from customer,sale where sale.customerId=customer.id && sale.categoryId='".$categoryId."' && sale.memoNo='".$memo."'";
        $customer = db_select($query)[0]['address'];
        if(empty($customer)){
//        customer
            $query = "insert into payment (id,details,amount,date,customerId,saleId,partyPaymentMemoNo) VALUES (NULL,NULL,'".$total."','".$date."',NULL,(select sale.id from sale where sale.categoryId='".$categoryId."' && sale.memoNo='".$memo."' ),NULL)";
            db_insert($query);

            //    decreasing due
            $query = "update customerduepayment,sale set customerduepayment.amount = customerduepayment.amount-'".$total."' where sale.id=customerduepayment.saleId && sale.categoryId='".$categoryId."' && sale.memoNo='".$memo."'";
            db_update($query);

        }else{
//        party
            $query = "select category.name as name from category where category.id='".$categoryId."'";
            $category = db_select($query)[0]['name'];
            $details = "cash on returns ".$category."-".$memo;

            $query = "select memono.partyPayment as partyPayment from memono";
            $paymentMemoNo = db_select($query)[0]['partyPayment'];

            $query = "INSERT INTO `payment` (`id`, `details`, `amount`, `date`, `customerId`, `saleId`, `partyPaymentMemoNo`) VALUES (NULL, '".$details."', '$total', '".$date."', (select sale.customerId from sale where sale.categoryId='".$categoryId."' && sale.memoNo='".$memo."' ), NULL, '".$paymentMemoNo."');";
            db_insert($query);

            $query = "update memono set memono.partyPayment = memono.partyPayment + 1";
            db_update($query);

        }
    }

    return $id[0]['id'];
}

function getMemoNo($categoryId){
    $memoNameNo = array();
    $query = "select name from category where id = '".$categoryId."'";
    $data = db_select($query)[0]['name'];
    array_push($memoNameNo,$data);
    $query = "select ".$data." from memono";
    $data = db_select($query)[0][$data];
    array_push($memoNameNo,$data);
    return $memoNameNo;
}
//sale page
function db_insert_customer_payment_due($saleId,$payment,$due){
    //    payment insert
    $time = time();
    $date = date('Y-m-d',$time);
    $query = "INSERT INTO `payment` (`id`, `details`, `amount`, `date`, `customerId`, `saleId`, `partyPaymentMemoNo`) VALUES (NULL, NULL, '".$payment."', '$date', NULL, '".$saleId."', NULL);";
    db_insert($query);

    //    due insert
    $query = "INSERT INTO `due` (`id`, `amount`, `saleId`) VALUES (NULL, '".$due."', '".$saleId."');";
    db_insert($query);

    $query = "INSERT INTO `customerduepayment` (`id`, `amount`, `saleId`) VALUES (NULL, '".$due."', '".$saleId."');";
    db_insert($query);

}

function db_insert_party_payment_due($partyId,$payment,$saleId,$due){
//    payment insert
    $time = time();
    $date = date('Y-m-d',$time);
    $query = "select concat(\"Cash on \",category.name,\" : \",sale.memoNo) as details from sale,category where sale.categoryId=category.id && sale.id='".$saleId."'";
    $details = db_select($query)[0]['details'];
    $query = "select memono.partyPayment from memono";
    $paymentMemoNo = db_select($query)[0]['partyPayment'];

    $query = "INSERT INTO `payment` (`id`, `details`, `amount`, `date`, `customerId`, `saleId`, `partyPaymentMemoNo`) VALUES (NULL, '".$details."', '$payment', '".$date."', '".$partyId."', '".$saleId."', '".$paymentMemoNo."');";
    db_insert($query);

    $query = "update memono set memono.partyPayment = memono.partyPayment + 1";
    db_update($query);

//    due insert
    $query = "INSERT INTO `due` (`id`, `amount`, `saleId`) VALUES (NULL, '".$due."', '".$saleId."');";
    db_insert($query);


}

//shop details page
function db_get_sales_details($dateFrom,$dateTo){
    $query = "select sale.id,customer.name as customer,category.name as category,sale.memoNo as memo,sale.date,sale.total,sale.comission,sale.net,payment.amount as payment,due.amount as due from customer,sale,due,category,payment where sale.customerId=customer.id && sale.categoryId=category.id && sale.id=due.saleId && payment.saleId=sale.id && payment.date=sale.date && sale.date between '".$dateFrom."' and '".$dateTo."' order by sale.id asc";
    $rows = db_select($query);
    $html = '<thead>
                <tr>
                    <th>Customer</th>
                    <th>Category</th>
                    <th>Memo</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Comission</th>
                    <th>Net</th>
                    <th>Payment</th>
                    <th>Due</th>
                </tr>
            </thead>';
    foreach ($rows as $row){
        $html .= '<tr>
                    <td>'.$row['customer'].'</td>
                    <td>'.$row['category'].'</td>
                    <td><a target="_blank" href="/cash-memo.php?saleId='.$row['id'].'">'.$row['memo'].'</a></td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['total'].'</td>
                    <td>'.$row['comission'].'</td>
                    <td>'.$row['net'].'</td>
                    <td>'.$row['payment'].'</td>
                    <td>'.$row['due'].'</td>
                </tr>';
    }

    return $html;
}

function db_get_customer_due_details(){
$query = "select sale.id,customer.name as customer,category.name as category,sale.memoNo as memo,customerduepayment.amount as due from customer,category,sale,customerduepayment where customer.id=sale.customerId&&sale.categoryId=category.id && sale.id=customerduepayment.saleId && customerduepayment.amount!='0'";
$rows = db_select($query);

$html = '<thead>
                <tr>
                    <th>Customer</th>
                    <th>Category</th>
                    <th>Memo</th>
                    <th>Due</th>
                </tr>
            </thead>';
    foreach ($rows as $row){
        $html .= '<tr>
                    <td>'.$row['customer'].'</td>
                    <td>'.$row['category'].'</td>
                    <td><a target="_blank" href="/cash-memo.php?saleId='.$row['id'].'">'.$row['memo'].'</a></td>
                    <td>'.$row['due'].'</td>
                </tr>';
    }

    return $html;

}

function db_get_customer_due_payment($dateFrom,$dateTo){
    $query = "select sale.id as saleId,customer.name as customer,category.name as category,sale.memoNo as memo,sale.date,sale.net,due.amount as pastDue,(select sum(payment.amount) from payment where payment.saleId=sale.id) as totalPayment,customerduepayment.amount as presentDue from sale,customer,category,due,customerduepayment where customer.id=sale.customerId && sale.categoryId=category.id && sale.id=due.saleId && sale.id=customerduepayment.saleId && sale.date between '".$dateFrom."' and '".$dateTo."' order by sale.id";
    $rows = db_select($query);
    $html = '<thead>
                <tr>
                    <th>Customer</th>
                    <th>Category</th>
                    <th>Memo</th>
                    <th>Date</th>
                    <th>Net</th>
                    <th>Past Due</th>
                    <th>Total Payment</th>
                    <th>Present Due</th>
                </tr>
            </thead>';
    foreach ($rows as $row){
        $html .= '<tr>
                    <td>'.$row['customer'].'</td>
                    <td>'.$row['category'].'</td>
                    <td><a target="_blank" href="/customer-due-payment-details.php?saleId='.$row['saleId'].'">'.$row['memo'].'</a></td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['net'].'</td>
                    <td>'.$row['pastDue'].'</td>
                    <td>'.$row['totalPayment'].'</td>
                    <td ';
        if($row['presentDue']>0) $html .= 'class="danger"';
        $html.=        '>'.$row['presentDue'].'</td>
                </tr>';
    }

    return $html;
}

function db_get_returns($dateFrom,$dateTo){
    $query = "select returns.id as returnId,customer.name as customer,category.name as category,sale.memoNo as memo,returns.date, returns.total as totalReturns  from sale,customer,category,returns where sale.categoryId=category.id && sale.customerId  = customer.id && sale.id = returns.saleId && returns.date between '".$dateFrom."' and '$dateTo' order by returns.id asc";
    $rows = db_select($query);
    $html = '<thead>
                <tr>
                    <th>Customer</th>
                    <th>Category</th>
                    <th>Memo</th>
                    <th>Date</th>
                    <th>Total Return</th>
                </tr>
            </thead>';
    foreach ($rows as $row){
        $html .= '<tr>
                    <td>'.$row['customer'].'</td>
                    <td>'.$row['category'].'</td>
                    <td><a target="_blank" href="/returns-details.php?returnId='.$row['returnId'].'">'.$row['memo'].'</a></td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['totalReturns'].'</td>
                </tr>';
    }
    return $html;
}

//cash memo page
function db_getCashMemo($saleId){
    $query = "select subcategory.name,soldproducts.pcs,soldproducts.unitPrice,(soldproducts.pcs*soldproducts.unitPrice) as total from subcategory,soldproducts where soldproducts.saleId='".$saleId."' && soldproducts.subCategoryId=subcategory.id";
    $rows = db_select($query);
    $html = '<thead>
                <tr>
                    <th>SL.</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Cost</th>
                    
                </tr>
            </thead>';
    $counter = 1;
    foreach ($rows as $row){
        $html .= '<tr>
                    <td>'.($counter++).'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['pcs'].'</td>
                    <td>'.$row['unitPrice'].'</td>
                    <td>'.$row['total'].'</td>
                </tr>';
    }

    return $html;
}
//customer due payment details page

function db_get_customer_due_payment_details($saleId){
    $query = "select payment.date,payment.amount as payment from payment where payment.saleId='".$saleId."'";
    $rows = db_select($query);
    $html = '<thead>
                <tr>
                    <th>SL.</th>
                    <th>Date</th>
                    <th>Payment</th>
                </tr>
            </thead>';
    $counter = 1;
    foreach ($rows as $row){
        $html .= '<tr>
                    <td>'.($counter++).'.</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['payment'].' tk</td>
                </tr>';
    }

    return $html;
}
//return details page
function db_get_return_details($returnId){
    $query = "select subcategory.name,returnsproducts.pcs,returnsproducts.unitPrice as price,(returnsproducts.pcs*returnsproducts.unitPrice) as cost from returnsproducts,subcategory where returnsproducts.returnsId='$returnId' && returnsproducts.subCategoryId=subcategory.id";
    $rows = db_select($query);
    $html = '<thead>
                <tr>
                    <th>SL.</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>';
    $counter = 1;
    foreach ($rows as $row){
        $html .= '<tr>
                    <td>'.($counter++).'.</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['pcs'].'</td>
                    <td>'.$row['price'].'</td>
                    <td>'.$row['cost'].' tk</td>
                </tr>';
    }

    return $html;
}