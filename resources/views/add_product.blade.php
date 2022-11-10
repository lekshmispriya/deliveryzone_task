@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <b>{{ __('Product List') }}</b>
                    <div>
                    <form id="addForm"  method="post" enctype="multipart/form-data">
                        @csrf
                         <?php if(isset($product[0]->id))
                             {
                               
                               ?>
                            <input type="hidden" id="id" name="id" value="<?php echo  isset($product[0]->id)?$product[0]->id:'' ?>" required ><br>
                            
                               <?php
                             }
                            ?>
                            <label for="fname">Name:</label><br>
                            <input type="text" id="name" name="name" value="<?php echo  isset($product[0]->name)?$product[0]->name:'' ?>" required ><br>
                            <label for="lname">SKU:</label><br>
                            <input type="text" id="sku" name="sku" value="<?php echo  isset($product[0]->sku)?$product[0]->sku:'' ?>" required><br>
                            <label for="lname">Price:</label><br>
                            <input type="text" id="price" name="price" value="<?php echo  isset($product[0]->price)?$product[0]->price:'' ?>" required><br>
                            <label for="lname">Image:</label><br>
                            <input type="file" id="image" name="image" value="" ><br>
                            <?php
                             if(isset($product[0]->image))
                             {
                               $image =url('/public/images'.$product[0]->image);
                               ?>
                            <a href="{{image}}" target="_blank">View Image</a>
                               <?php
                             }
                            ?>
                            
                            <label for="lname">Status:</label><br>
                             <select name="status" required>
                                <option value="">Select</option>
                                <?php 
                                 $selected ="";
                                 $sselected ="";
                                 if(isset($product[0]->status))
                                    {
                                      if($product[0]->status == 0)
                                      {
                                        $selected ="selected";
                                      }
                                      else{
                                        $sselected ="selected";
                                      }
                                    }
                                ?>
                                <option {{$selected}} value="0">Inactive</option>
                                <option {{$sselected}} value="1">Active</option>
                             </select>
                           
                            <br>
                            <br>
                            <input type="submit" value="Submit">
                     </form> 

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
