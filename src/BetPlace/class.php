<?php

class Carrito{
	var $apuestas = array();


	function addCarrito($apuesta){
		array_push($this->apuestas, $apuesta);
	}
	function deleteCarrito(){
		return array_pop($this->apuestas);
	}	


	function toString(){
		return (string)$this->apuestas[0];
	}
}

class Apuesta{

	var $customerid;
	var $optionid;
	var $bet;
	var $ratio;
	var $outcome;
	var $betid;	
	var $optiondesc;
	var $betdesc;
	
	function setApuesta($customerid, $optionid, $bet, $ratio, $outcome, $betid, $optiondesc, $betdesc){
		$this->customerid = $customerid;
		$this->optionid = $optionid;
		$this->bet = $bet;
		$this->ratio = $ratio;
		$this->outcome = $outcome;
		$this->betid = $betid;
		$this->optiondesc = $optiondesc;
		$this->betdesc = $betdesc;
	}
	
}

?>