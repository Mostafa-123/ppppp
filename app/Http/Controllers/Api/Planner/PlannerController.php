<?php

namespace App\Http\Controllers\Api\Planner;

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Resources\PlanResource;

use App\Models\Plan;
use App\Http\Traits\GeneralTraits;
use App\Http\Controllers\Controller;
use App\Http\responseTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\Planner;

class PlannerController extends Controller
{
    use GeneralTraits;

    use responseTrait;
    public function addPlan(Request $request){

        $validator=Validator::make($request->all(),[
            'name'=>'required|max:255',
            'description'=>'required|max:255',
            'price'=>'required',
            'photos',
        ]);
        if ($validator->fails()) {
            return $this->response(null,$validator->errors(),400);
        }
        $result=Plan::create($request->only(['name','description','price']));
        if($request->photos[0]){
            for($i=0;$i<count($request->photos);$i++) {
                $path=$this->uploadMultiFile($request,$i,'planPhotos','photos');
                PlanPhoto::create([
                    'photoname' => $path,
                    'plan_id'=>$result->id,
                ]);}
            }

        if($result){
            return $this->response(new PlanResource( $result),'done',201);
        }else{
            return $this->response(null,'plan is not saved',405);
        }
    }
    public function deletePlan($plan_id){
        $plan=Plan::find($plan_id);
        if($plan){
            $photos=$plan->planPhoto;
            if($photos){
                for($i=0;$i<count($photos);$i++) {
                    $path=$photos[$i]->photoname;
                    $this->deleteFile($path);
                    }
                }
            $plan->delete();
            return $this->response('','plan deleted successfully',201);
        }
        return $this->response('', 'this plan_id not found',401);
    }
    public function getPlanPhoto($plan_id,$photo_id){
        $plan=Plan::find($plan_id);
        if($plan){
            $photo=PlanPhoto::find($photo_id);
            if($photo){
                return $this->getFile($photo->photoname);
            }
            return $this->response('', "This plan doesn't has photo",401);
        }
        return $this->response('', 'this plan_id not found',401);
    }
    public function updatePlan(Request $request, $plan_id)
    {
        $plan = plan::find($plan_id);

        if ($plan) {
            $photos = $plan->planPhoto;

            if ($request->photos[0]) {
                if ($photos) {
                    for ($i = 0; $i < count($photos); $i++) {
                        $path = $photos[$i]->photoname;

                        $photo = PlanPhoto::where('photoname', $path)->get();
                        // print($photo[0]);die;
                        $photo[0]->delete();
                        $this->deleteFile($path);
                    }
                    for ($i = 0; $i < count($request->photos); $i++) {
                        $path = $this->uploadMultiFile($request, $i, 'planPhotos', 'photos');
                        PlanPhoto::create([
                            'photoname' => $path,
                            'plan_id' => $plan->id,
                        ]);
                    }
                } else if ($photos == null) {
                    for ($i = 0; $i < count($request->photos); $i++) {
                        $path = $this->uploadMultiFile($request, $i, 'planPhotos', 'photos');
                        PlanPhoto::create([
                            'photoname' => $path,
                            'plan_id' => $plan->id,
                        ]);
                    }
                }
            }
            $newData = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ];

            $plan->update($newData);
        } else {
            return $this->response('', 'plan not  found', 404);
        }
        return $this->response(new PlanResource($plan), 'hall updated successfully', 200);
    }

    public function addPhotoToMyplan(Request $request, $plan_id)
    {
        $plan = plan::find($plan_id);

        if ($plan) {
            if ($request->photos[0]) {
                for ($i = 0; $i < count($request->photos); $i++) {
                    $path = $this->uploadMultiFile($request, $i, 'planPhotos', 'photos');
                    PlanPhoto::create([
                        'photoname' => $path,
                        'plan_id' => $plan->id,
                    ]);
                }
            }
        } else {
            return $this->response('', 'plan not founded successfully', 200);
        }
        return $this->response(new PlanResource($plan), 'photos added successfully', 200);
    }
    public function viewConfirmedBookingsPlans()
    {
        $bookingplans = PlanRequest::where('status', 'confirmed')->get();

        return response()->json([
                'message' => 'Pending bookings for plans retrieved successfully',
                'data' => $bookingplans], 200);

    }
    public function viewCancelledBookingsPlans()
    {
        $bookingplans = PlanRequest::where('status', 'cancelled')->get();

        return response()->json([
                'message' => 'Pending bookings for plans retrieved successfully',
                'data' => $bookingplans], 200);

    }
    public function viewBookingsplans()
    {
        $bookingplans = PlanRequest::where('status', 'unconfirmed')->get();

        return response()->json([
                'message' => 'Pending bookings for plans retrieved successfully',
                'data' => $bookingplans], 200);

    }

    public function confirmBookingPlan($bookingplanId)
    {
        $bookingplan = PlanRequest::findOrFail($bookingplanId);

        $bookingplan->status = 'confirmed';
        $bookingplan->save();

        return response()->json([
            'message' => 'Booking confirmed successfully',
            'data' => $bookingplan
        ], 200);    }

    public function rejectBooking($bookingplanId)
    {
        $bookingplan = PlanRequest::findOrFail($bookingplanId);

        $bookingplan->status = 'cancelled';
        $bookingplan->save();

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'data' => $bookingplan
        ], 200);    }



}
