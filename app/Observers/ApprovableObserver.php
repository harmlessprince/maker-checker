<?php

namespace App\Observers;

use App\Enums\Operations;
use App\Models\Approval;
use Illuminate\Database\Eloquent\Model;

class ApprovableObserver
{
    	/**
	 * Handle to the Model "created" event.
	 *
	 * @param Model $model
	 * @return bool
	 */
	public function creating(Model $model)
	{
		$model->setOperation(Operations::CREATE)->storeApproval();
		return false;
	}

	/**
	 * Handle the Model "updated" event.
	 *
	 * @param Model $model
	 * @return bool
	 */
	public function updating(Model $model)
	{
		$model->setOperation(Operations::UPDATE)->storeApproval();
		return false;
	}

	/**
	 * Handle the Model "deleted" event.
	 *
	 * @param Model $model
	 * @return bool
	 */
	public function deleting(Model $model)
	{
		$model->setOperation(Operations::DELETE)->storeApproval();
		return false;
	}
}
