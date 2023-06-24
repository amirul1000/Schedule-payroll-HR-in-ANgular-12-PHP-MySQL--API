import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { PeopleService } from '../people.service';
import { FormGroup, FormControl, FormArray, FormBuilder } from '@angular/forms'  

import { CalendarOptions , DateSelectArg, EventClickArg, EventApi } from '@fullcalendar/angular';


import {NgbModal, NgbDate,NgbDateStruct, NgbCalendar,NgbInputDatepickerConfig} from '@ng-bootstrap/ng-bootstrap';

import { NgxSpinnerService } from "ngx-spinner";  
import { ToastrService } from 'ngx-toastr';


@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  user:any; 
  first_name:any;
  last_name:any;
  email:any;
  users_id:any;
  business:any;
  business_name:any;
  business_id:any;
  phone_no:any;
  date_of_birth!: NgbDateStruct;
  date!: {year: number, month: number};
  gender:any;
  file_picture:any;
  address:any;
  city:any;
  country:any;
  postcode:any;

  

  constructor(private peopleService:PeopleService,
    private SpinnerService:NgxSpinnerService,
    private toastr:ToastrService) {

      let user_json:any = localStorage.getItem('user');
      this.user =  JSON.parse(user_json); 
      console.log(this.user);  
      this.file_picture = this.user.file_picture;
      this.first_name  = this.user.first_name; 
      this.last_name  = this.user.last_name; 
      this.email = this.user.email; 
      this.users_id = this.user.id;
  
      if(localStorage.getItem('business')){
        let businesss_json:any = localStorage.getItem('business');
        this.business =  JSON.parse(businesss_json); 
        this.business_name = this.business.business_name;
        this.business_id = this.business.id;
     }
  

     }

  ngOnInit(): void {
     this.getProfile();
  }

  getProfile(){
    this.peopleService.getProfile({params:{
      users_id:this.users_id}}).subscribe((response: any) => {
        console.log(response);
      this.SpinnerService.show();  
          let resobj =response; 
              if(resobj[0].status=='success'){  
                  this.toastr.success(resobj[0].msg);    
                  this.first_name= resobj[0]['user'][0].first_name;
                  this.last_name= resobj[0]['user'][0].last_name;
                  this.email= resobj[0]['user'][0].email;
                  this.phone_no= resobj[0]['user'][0].phone_no;
                  if( resobj[0]['user'][0].dob){
                  const [year, month, day] =  resobj[0]['user'][0].dob.split('-');
                  const obj = { year: parseInt(year), month: parseInt(month), day:parseInt(day.split(' ')[0].trim()) };
                  this.date_of_birth= obj;
                  }
                  this.gender= resobj[0]['user'][0].gender;
                  this.address= resobj[0]['user'][0].address;
                  this.city= resobj[0]['user'][0].city;
                  this.country= resobj[0]['user'][0].country;
                  this.postcode= resobj[0]['user'][0].zip;
                  
                  this.SpinnerService.hide();   
                  
              }
      }, 
      (error: any) => {
      console.log(error);
      }); 

  }

  updateProfile(){

    if(this.date_of_birth===null){
      this.toastr.error("Date is a required field");
        return;
    }

    let data_str = JSON.stringify( { 
      first_name: this.first_name,
      last_name:this.last_name,
      email:this.email,
      phone_no: this.phone_no,
      date_of_birth:this.date_of_birth.year+'-'+this.date_of_birth.month +'-'+this.date_of_birth.day,
      gender: this.gender,
      address:this.address,
      city:this.city,
      country:this.country,
      postcode:this.postcode,
      users_id:this.users_id
  });
    
    this.peopleService.updateProfile(data_str).subscribe((response: any) => {
      this.SpinnerService.show();  
      let resobj = JSON.parse(response); 
              if(resobj[0].status=='success'){                    
                this.toastr.success(resobj[0].msg);   
                this.SpinnerService.hide();                  
              }
              else{
                this.toastr.error(resobj[0].msg);    
                this.SpinnerService.hide();      
              }
      }, 
      (error: any) => {
      console.log(error);
      }); 

  }

}
