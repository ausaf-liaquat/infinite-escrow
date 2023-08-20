<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{
    use HasFactory;

    public function seller(){
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function disputer(){
        return $this->belongsTo(User::class,'disputer_id');
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    public function category(){

        return $this->belongsTo(Category::class);
    }

    public function scopeAccepted()
    {
        return $this->where('status',2);
    }

    public function scopeNotAccepted()
    {
        return $this->where('status',0);
    }

    public function scopeCompleted()
    {
        return $this->where('status',1);
    }

    public function scopeDisputed()
    {
        return $this->where('status',8);
    }

    public function scopeCanceled()
    {
        return $this->where('status',9);
    }

    public function getEscrowStatusAttribute(){
        if($this->status == 0){
            $html = '<span class="badge badge--info">'.trans("Not Accepted").'</span>';
        }elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans("Completed").'</span>';
        }elseif($this->status == 2){
            $html = '<span class="badge badge--primary">'.trans("Accepted").'</span>';
        }elseif($this->status == 8){
            $html = '<span class="badge badge--danger">'.trans("Disputed").'</span>';
        }else{
            $html = '<span class="badge badge--warning">'.trans("Cancelled").'</span>';
        }
        return $html;
    }
}
