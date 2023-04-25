<?php

namespace App\Http\Controllers\Api\Owner;



use Illuminate\Http\Request;
use App\Http\Resources\hallResource;

use App\Models\Hall;
use App\Models\halls;
use App\Models\Booking;
use App\Http\Traits\GeneralTraits;
use App\Http\Controllers\Controller;
use App\Http\responseTrait;
use App\Models\Photo;
use Illuminate\Support\Facades\Validator;




class OwnerController extends Controller
{
    use GeneralTraits;

    use responseTrait;


    public function addHallRequests(Request $request){
            $validator=Validator::make($request->all(),[
                'name'=>'required|max:255',
                'address'=>'required|max:255',
                'rooms'=>'required|integer',
                'chairs'=>'required|integer',
                'price'=>'required|double',
                'hours'=>'required|double',
                'tables'=>'required|integer',
                'type'=>'required|max:255',
                'capacity'=>'required|integer',
                'available'=>'required|boolean',
                'start_party'=>'required|double',
                'end_party'=>'required|double',
            ]);
            if ($validator->fails()) {
                return $this->response(null,$validator->errors(),400);
            }
            $result=Hall::create($request->only(['name','address','rooms','chairs','price','hours','tables','type','capacity','available','start_party','end_party']));
            if($request->photos[0]){
                for($i=0;$i<count($request->photos);$i++) {
                    $path=$this->uploadMultiFile($request,$i,'hallPhotos','photos');
                    Photo::create([
                        'photoname' => $path,
                        'hall_id'=>$result->id,
                    ]);}
                }

            if($result){
                return $this->response(new hallResource( $result),'done',201);
            }else{
                return $this->response(null,'halls is not saved',405);
            }
        }

        public function getHallPhoto($hall_id,$photo_id){
            $hall=hall::find($hall_id);
            if($hall){
                $photo=Photo::find($photo_id);
                if($photo){
                    return $this->getFile($photo->photoname);
                }
                return $this->response('', "This Patient doesn't has photo",401);
            }
            return $this->response('', 'this Pateint_id not found',401);
        }

    public function DestroyAllHallRequest (){
        $reqs = Hall::where('status', 'cancelled')->get();

        foreach ($reqs as $req) {
            $req->delete();
        }

        return response()->json([
            'message' => 'Rejected Halls deleted successfully',
        ], 200);
    }




    public function destroyHallRequest($id){

        $result=Hall::where('status', 'cancelled')->find($id);

        if(!$result){
            return $this->response(null,'The hall request Not Found',404);
        }

        $result->delete($id);

        if($result){
            return $this->response(null,'The hall request deleted',200);
        }else{
            return $this->response(null,'The hall request not deleted',405);

        }

    }


    public function updateAllInfoOfHallRequest(Request $req ,$id){
        $result=Hall::where('status', 'cancelled')->find($id);
        if(!$result){
            return $this->response(null,'The hall Not Found',404);
        }

        $result->update($req->all());

        if($result){
            return $this->response(new hallResource($result),'The hall update',201);
        }else{
            return $this->response(null,'The hall not update',400);
        }
    }

    public function confirmBooking($bookingId){
        $booking = Booking::findOrFail($bookingId);

        $booking->status = 'confirmed';
        $booking->save();

        return response()->json([
            'message' => 'Booking confirmed successfully',
            'data' => $booking
        ], 200);    }

    public function rejectBooking($bookingId){
        $booking = Booking::findOrFail($bookingId);

        $booking->status = 'cancelled';
        $booking->save();

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'data' => $booking
        ], 200);    }




    public function destroyRejectedBookings(){
        $bookings = Booking::where('status', 'cancelled')->get();

        foreach ($bookings as $booking) {
            $booking->delete();
        }

        return response()->json([
            'message' => 'Rejected bookings deleted successfully',
        ], 200);
    }

}
