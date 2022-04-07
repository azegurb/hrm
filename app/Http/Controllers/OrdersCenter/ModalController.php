<?php

namespace App\Http\Controllers\OrdersCenter;

use App\Http\Controllers\Controller;

class ModalController extends Controller
{
    public function common($data = null)
    {

        return view('pages.orders_center.component._modals' , compact('data'));
    }

    /**
     * Business Trip Inputs Component parser
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function business_trip()
    {
        return view('pages.orders_center.component.order-type-panel-body.businessTrip');
    }

    /**
     * Appointment view components
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function appointment()
    {
        return view('pages.orders_center.component.order-type-panel-body.appointment');
    }

    /**
     * Assignment view components
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignment()
    {
        return view('pages.orders_center.component.order-type-panel-body.assignment');
    }

    public function dismissal()
    {
        return view('pages.orders_center.component.order-type-panel-body.dismissal');
    }

    // Vacation Trip Inputs Component parser
    public function vacation()
    {

        return view('pages.orders_center.component.order-type-panel-body.vacation');
    }

    //replacement order
    public function replacement()
    {
        return view('pages.orders_center.component.order-type-panel-body.replacement');
    }

    //reward
    public function reward()
    {
        return view('pages.orders_center.component.order-type-panel-body.reward');
    }

    //damage compensation
    public function damage_compensation()
    {
        return view('pages.orders_center.component.order-type-panel-body.damageCompensation');
    }

    //damage
    public function damage()
    {
        return view('pages.orders_center.component.order-type-panel-body.damage');
    }

    //warning
    public function warning()
    {
        return view('pages.orders_center.component.order-type-panel-body.warning');
    }

    //fiancial aid form
    public function financialAid()
    {
        return view('pages.orders_center.component.order-type-panel-body.financialAid');
    }

    //additional work time fomr
    public function additionalWorkTime()
    {
        return view('pages.orders_center.component.order-type-panel-body.additionalWorkTime');
    }

    //nonWorkingDaysSelection
    public function nonWorkingDaysSelection()
    {
        return view('pages.orders_center.component.order-type-panel-body.nonWorkingDaysSelection');
    }

    //compensationForVacationDays
    public function compensationForVacationDays()
    {
        return view('pages.orders_center.component.order-type-panel-body.compensationForVacationDays');
    }

    //discipline
    public function discipline()
    {
        return view('pages.orders_center.component.order-type-panel-body.discipline');
    }

    //add state
    public function addState()
    {
        return view('pages.orders_center.component.order-type-panel-body.staffOpening');
    }

    //remove state
    public function removeState()
    {

        return view('pages.orders_center.component.order-type-panel-body.staffCancellation');
    }

    // salaryAddition
    public function orderTransfer()
    {
        return view('pages.orders_center.component.order-type-panel-body.orderTransfer');
    }

    // salary-deduction
    public function salary_deduction()
    {
        return view('pages.orders_center.component.order-type-panel-body.salaryDeduction');
    }

    //vacationRecall
    public function vacationRecall()
    {
        return view('pages.orders_center.component.order-type-panel-body.vacationRecall');
    }

    //qualification degree
    public function QualificationDegree()
    {
        return view('pages.orders_center.component.order-type-panel-body.QualificationDegree');
    }

}

