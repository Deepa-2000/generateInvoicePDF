<?php 
  require ("fpdf/fpdf.php");
  require ("word.php");
  require "db.php"; 

  //customer and invoice details
  $info=[
    "name"=>"",
    "product"=>"",
    "price"=>"",
    "qty"=>"",
    "address"=>",",
    "city"=>"",
    "invoice_no"=>"",
    "invoice_date"=>"",
    "total_amt"=>"",
    "words"=>"",
  ];
  
  //Select Invoice Details From Database
  $sql="select * from customers where ID='{$_GET["id"]}'";
  $res=$con->query($sql);
  if($res->num_rows>0){
	  $row=$res->fetch_assoc();
	//   
	  $obj=new IndianCurrency($row["total"]);
	//  
// 
	  $info=[
		"name"=>$row["name"],
        "product"=>$row['product'],
        "price"=>$row['price'],
        "qty"=>$row['qty'],
		"address"=>"ABC colony ,Noida",
		"city"=>"New Delhi, India",
		"invoice_no"=>"45676564",
		"invoice_date"=>date("d-m-Y",strtotime("16-05-2023")),
		"total_amt"=>$row["total"],
		"words"=> $obj->get_words(),
	  ];
  }

  $products_info[]=[
    "product"=>$info['product'],
    "price"=>$info['price'],
    "qty"=>$info['qty'],
    "total_amt"=>$info['total_amt']

  ];


  class PDF extends FPDF
  {
    function Header(){
    //   
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,"ABC COMPUTERS",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"123 Street,",0,1);
      $this->Cell(50,7,"Deepa 110085.",0,1);
      $this->Cell(50,7,"PH : 9802626353",0,1);
    //   
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"INVOICE",0,1);
    //   
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    // 
    function body($info,$products_info){
    //   
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,$info["name"],0,1);
      $this->Cell(50,7,$info["address"],0,1);
      $this->Cell(50,7,$info["city"],0,1);
    //   
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice No : ".$info["invoice_no"]);
    //   
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);
    //   
      //Display Table headings
      $this->SetY(95);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(80,9,"DESCRIPTION",1,0);
      $this->Cell(40,9,"PRICE",1,0,"C");
      $this->Cell(30,9,"QTY",1,0,"C");
      $this->Cell(40,9,"TOTAL",1,1,"C");
      $this->SetFont('Arial','',12);  
      
      //Display table product rows
      $this->Cell(80,9,$info["product"],"LR",0);
      $this->Cell(40,9,$info["price"],"R",0,"R");
      $this->Cell(30,9,$info["qty"],"R",0,"C");
      $this->Cell(40,9,$info["total"],"R",1,"R");
    
      //Display table empty rows
      $this->Cell(80,9,"","LR",0);
      $this->Cell(40,9,"","R",0,"R");
      $this->Cell(30,9,"","R",0,"C");
      $this->Cell(40,9,"","R",1,"R");

      //Display table total row
      $this->SetFont('Arial','B',12);
      $this->Cell(150,9,"TOTAL",1,0,"R");
      $this->Cell(40,9,$info["total_amt"],1,1,"R");
   
      //Display amount in words
      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,9,"Amount in Words ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,9,$info["words"],0,1);
    //   
    }
    function Footer(){
    //   
      //set footer position
      $this->SetY(-50);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"for ABC COMPUTERS",0,1,"R");
      $this->Ln(15);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
    //   
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
    //   
    }
    // 
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$products_info);
  $pdf->Output();
?>