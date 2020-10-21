<?php

namespace App\Models\PostgreSQL;

class RequisitionItemsModel
{
	private $idItemsRequisition;
	private $idRequisition;
	private $idProducts;
	private $abo;
	private $rhd;
	private $unitQuantity;
	private $mlQuantity;
	private $phenotyped;
	private $interval;
	private $dateScheduled;
	private $dateTimeRegister;
	

	/**
	 * Get the value of idItemsRequisition
	 */ 
	public function getIdItemsRequisition(): int
	{
		return $this->idItemsRequisition;
	}

	/**
	 * Set the value of idItemsRequisition
	 *
	 * @return  self
	 */ 
	public function setIdItemsRequisition($idItemsRequisition): RequisitionItemsModel
	{
		$this->idItemsRequisition = $idItemsRequisition;

		return $this;
	}

	/**
	 * Get the value of idRequisition
	 */ 
	public function getIdRequisition(): int
	{
		return $this->idRequisition;
	}

	/**
	 * Set the value of idRequisition
	 *
	 * @return  self
	 */ 
	public function setIdRequisition($idRequisition): RequisitionItemsModel
	{
		$this->idRequisition = $idRequisition;

		return $this;
	}

	/**
	 * Get the value of idProducts
	 */ 
	public function getIdProducts(): int
	{
		return $this->idProducts;
	}

	/**
	 * Set the value of idProducts
	 *
	 * @return  self
	 */ 
	public function setIdProducts($idProducts): RequisitionItemsModel
	{
		$this->idProducts = $idProducts;

		return $this;
	}

	/**
	 * Get the value of abo
	 */ 
	public function getAbo(): string
	{
		return $this->abo;
	}

	/**
	 * Set the value of abo
	 *
	 * @return  self
	 */ 
	public function setAbo($abo): RequisitionItemsModel
	{
		$this->abo = $abo;

		return $this;
	}

	/**
	 * Get the value of rhd
	 */ 
	public function getRhd(): string
	{
		return $this->rhd;
	}

	/**
	 * Set the value of rhd
	 *
	 * @return  self
	 */ 
	public function setRhd($rhd): RequisitionItemsModel
	{
		$this->rhd = $rhd;

		return $this;
	}

	/**
	 * Get the value of unitQuantity
	 */ 
	public function getUnitQuantity(): string
	{
		return $this->unitQuantity;
	}

	/**
	 * Set the value of unitQuantity
	 *
	 * @return  self
	 */ 
	public function setUnitQuantity($unitQuantity): RequisitionItemsModel
	{
		$this->unitQuantity = $unitQuantity;

		return $this;
	}

	/**
	 * Get the value of mlQuantity
	 */ 
	public function getMlQuantity(): string
	{
		return $this->mlQuantity;
	}

	/**
	 * Set the value of mlQuantity
	 *
	 * @return  self
	 */ 
	public function setMlQuantity($mlQuantity): RequisitionItemsModel
	{
		$this->mlQuantity = $mlQuantity;

		return $this;
	}

	/**
	 * Get the value of phenotyped
	 */ 
	public function getPhenotyped(): string
	{
		return $this->phenotyped;
	}

	/**
	 * Set the value of phenotyped
	 *
	 * @return  self
	 */ 
	public function setPhenotyped($phenotyped): RequisitionItemsModel
	{
		$this->phenotyped = $phenotyped;

		return $this;
	}

	/**
	 * Get the value of interval
	 */ 
	public function getInterval(): string
	{
		return $this->interval;
	}

	/**
	 * Set the value of interval
	 *
	 * @return  self
	 */ 
	public function setInterval($interval): RequisitionItemsModel
	{
		$this->interval = $interval;

		return $this;
	}

	/**
	 * Get the value of dateScheduled
	 */ 
	public function getDateScheduled(): string
	{
		return $this->dateScheduled;
	}

	/**
	 * Set the value of dateScheduled
	 *
	 * @return  self
	 */ 
	public function setDateScheduled($dateScheduled): RequisitionItemsModel
	{
		$this->dateScheduled = $dateScheduled;

		return $this;
	}

	/**
	 * Get the value of dateTimeRegister
	 */ 
	public function getDateTimeRegister(): string
	{
		return $this->dateTimeRegister;
	}

	/**
	 * Set the value of dateTimeRegister
	 *
	 * @return  self
	 */ 
	public function setDateTimeRegister($dateTimeRegister): RequisitionItemsModel
	{
		$this->dateTimeRegister = $dateTimeRegister;

		return $this;
	}
}