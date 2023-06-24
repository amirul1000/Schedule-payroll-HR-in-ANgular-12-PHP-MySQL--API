import {  ANALYZE_FOR_ENTRY_COMPONENTS, Component, OnInit } from '@angular/core';

import { BusinessService } from '../business.service';
import {LocationsDataComponent} from '../locations/locations.data';
import { IDropdownSettings } from 'ng-multiselect-dropdown'

import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from "ngx-spinner";  
import { Router, ActivatedRoute, ParamMap } from '@angular/router';


import {NgbDateStruct, NgbModal} from '@ng-bootstrap/ng-bootstrap';


import { PeopleService } from '../people.service';

import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
  file_picture:any="";
  user :any ={};
  first_name:any;
  last_name:any;
  email:any;
  users_id : any;
  user_type : any;

  showBusinessModal:boolean = false;
  business_name : any;
  time_zone : any;
  address : any;

  dropdownListTimeZone: any[]=[];
  selectedItemsTimeZone: any[]=[];
  dropdownSettingsTimeZone:IDropdownSettings ={};

  business_list:any[] = [];
  business_id:any='';
  selected_business_id:any='';
  business_radio:any; 
  business:any;

  payrolls:any;
  tasks:any;
  isShown:any[]= [] ; 

  business_display:boolean=false;

  
  leave_start_date!: NgbDateStruct;
  leave_end_date!: NgbDateStruct;
  leave_type:any;
  showmodalLeave: boolean = false;
  leave_id:any=0;
  date!: {year: number, month: number};
  users_pay_details_id:any;


  constructor(private businessService:BusinessService,
    private locationsDataComponent:LocationsDataComponent,
    private peopleService:PeopleService,
    private SpinnerService:NgxSpinnerService,
    private toastr:ToastrService,private route: ActivatedRoute,
    private router: Router) { 

    let user_json:any = localStorage.getItem('user');
    this.user =  JSON.parse(user_json); 
    this.file_picture = this.user.file_picture;
    this.first_name  = this.user.first_name; 
    this.last_name  = this.user.last_name; 
    this.email = this.user.email; 
    this.users_id = this.user.id;
    this.user_type = this.user.user_type;
    
  }

  ngOnInit(): void {
     if(this.user_type!='Employee'){
        this.loadDropdownData();   
        this.getAllBusiness(); 
        this.businessService.countBusiness({params:{users_id:this.users_id}}).subscribe((response: any) => {
                    if(response==0){
                        this.toastr.error("You don't have any business yet.Please create this.");
                        this.showBusiness();
                    }else{
                      if(!localStorage.getItem('business')){
                          if(confirm("Your business is not selected now.Please choice a business")){
                          }
                        }
                        else{
                          let businesss_json:any = localStorage.getItem('business');
                          this.business =  JSON.parse(businesss_json); 
                          this.business_name = this.business.business_name;
                          this.selected_business_id = this.business.id;
                        }
                    }
          }, 
          (error: any) => {
          console.log(error);
        });
    }

    if(this.user_type=='Employee'){
      this.peopleService.getUsersPayroll({params:{
        users_id:this.users_id,
        business_id:this.business_id,
        }}).subscribe((response: any) => {
            this.payrolls = response[0].payroll;
            let k=0;
            this.payrolls.forEach((element: any)  => {
              this.isShown[k++] = true;
            });

        }, 
        (error: any) => {
        console.log(error);
        }); 

        this.loadUserSchedule();
    }
}

//Business
hideBusiness(){
  this.showBusinessModal = false;  
  this.ngOnInit();
  this.business_id = '';
}

showBusiness(){
  this.showBusinessModal = true;
}


saveBusiness(){
  if(typeof this.business_name=='undefined' || this.business_name==''){
    this.toastr.error('Business Name is a required field');      
    return;
   }
   if(typeof this.selectedItemsTimeZone[0]=='undefined' ||  this.selectedItemsTimeZone[0]==''){
    this.toastr.error('TimeZone is a required field');      
    return;
   }
   if(typeof this.address=='undefined' || this.address==''){
    this.toastr.error('Address is a required field');    
    return;  
   }

  this.businessService.saveBusiness({params:{users_id:this.users_id,business_id:this.business_id,business_name:this.business_name,time_zone:this.selectedItemsTimeZone[0].item_id,address:this.address}}).subscribe((response: any) => {
    this.SpinnerService.show();  
    let resobj =response; 
        if(resobj[0].status=='success'){  
            this.toastr.success(resobj[0].msg);
            localStorage.setItem('business',JSON.stringify(resobj[0].business[0]));
            this.hideBusiness();
            this.SpinnerService.hide();   
        }else{
          this.toastr.error(resobj[0].msg);     
          this.SpinnerService.hide();                
        }
        
    }, 
    (error: any) => {
    console.log(error);
    });
}

loadDropdownData(){
  this.dropdownListTimeZone = [];
  for(let i=0;i<this.locationsDataComponent.timezoneList.length;i++){
    this.dropdownListTimeZone.push( { item_id: this.locationsDataComponent.timezoneList[i], item_text: this.locationsDataComponent.timezoneList[i] });
   }
  this.selectedItemsTimeZone = [];
  this.dropdownSettingsTimeZone= {
  singleSelection: true,
  idField: 'item_id',
  textField: 'item_text',
 // selectAllText: 'Select All',
 // unSelectAllText: 'UnSelect All',
  itemsShowLimit: 1,
  allowSearchFilter: true 
  }
}
onItemSelect(item: any) {
  console.log(item);
}
onSelectAll(items: any) {
  console.log(items);
}

getAllBusiness(){
  this.SpinnerService.show();  
  this.businessService.getAllBusiness({params:{users_id:this.users_id}}).subscribe((response: any) => {
    if(response.length==0 && localStorage.getItem('business')){
        localStorage.removeItem("business");
      }    
      this.business_list = response;         
      this.SpinnerService.hide();   
    }, 
    (error: any) => {
    console.log(error);
    });
 }

 editBusiness(id:any){
  this.business_id = ''; 
  this.showBusinessModal = true;
  this.businessService.getBusiness({params:{users_id:this.users_id,business_id:id}}).subscribe((response: any) => {
    this.SpinnerService.show();  
        let resobj =response; 
            if(resobj[0].status=='success'){  
                this.toastr.success(resobj[0].msg);

                this.business_name  = resobj[0]['business'][0].business_name;
                this.selectedItemsTimeZone = [{ item_id: resobj[0]['business'][0].time_zone,item_text:resobj[0]['business'][0].time_zone} ];
                this.address = resobj[0]['business'][0].address;
                this.business_id = resobj[0]['business'][0].id;
                
            }else{
              this.toastr.error(resobj[0].msg);                  
            }
            this.SpinnerService.hide();   
    }, 
    (error: any) => {
    console.log(error);
    });
 }

 deleteBusiness(id:any){
  if(confirm("Are you sure to delete this business?All the associated data location,users location,area will be deleted.")){
    this.businessService.deleteBusiness({params:{users_id:this.users_id,business_id:id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
      let resobj =response; 
          if(resobj[0].status=='success'){  
              this.toastr.success(resobj[0].msg);
              this.getAllBusiness();
          }else{
            this.toastr.error(resobj[0].msg);                  
          }
          this.SpinnerService.hide();   
  }, 
  (error: any) => {
  console.log(error);
  });
}
}

switchBusiness(business_id:any){
  this.businessService.getBusiness({params:{users_id:this.users_id,business_id:business_id}}).subscribe((response: any) => {
    this.SpinnerService.show();  
    let resobj =response; 
        if(resobj[0].status=='success'){  
            this.toastr.success(resobj[0].msg);
            localStorage.setItem('business',JSON.stringify(resobj[0].business[0]));
            window.location.reload();  
           // this.ngOnInit();
           // this.SpinnerService.hide();   
        }else{
          this.toastr.error(resobj[0].msg);     
          this.SpinnerService.hide();                
        }
        
}, 
(error: any) => {
console.log(error);
});
}



toggleShow(i:any) {
  this.isShown[i] = ! this.isShown[i];
  
  }


  toggleBusiness(){
    this.business_display = !this.business_display;
  }


  //get_user_schedule   
  loadUserSchedule(){

    let datePipe = new DatePipe('en-US');

    let start_date: Date = new Date();
    let start_date1 = datePipe.transform(start_date, 'yyyy-MM-dd');


    let end_date: Date = new Date();
    end_date.setDate(start_date.getDate() + 7);
    let end_date1 = datePipe.transform(end_date, 'yyyy-MM-dd');
    
    this.peopleService.getUserSchedule({params:{
      users_id:this.users_id,
      business_id:this.business_id,
      start_date:start_date1,
      end_date:end_date1 
      }}).subscribe((response: any) => {
          this.tasks = response;
          console.log(this.tasks);
      }, 
      (error: any) => {
      console.log(error);
      }); 

  }

  showLeave(users_pay_details_id:any){
    this.showmodalLeave = true;
    this.users_pay_details_id = users_pay_details_id;
  }

  hideLeave(){
    this.showmodalLeave = false;

  }

  saveLeaveApply(){
    let  data_str = JSON.stringify( {
      users_id:this.users_id ,
      start_date:this.leave_start_date.year+'-'+this.leave_start_date.month +'-'+this.leave_start_date.day,
      end_date:this.leave_end_date.year+'-'+this.leave_end_date.month +'-'+this.leave_end_date.day,
      users_pay_details_id:this.users_pay_details_id,
      leave_type:this.leave_type           

    });

    this.peopleService.saveLeaveApply(data_str).subscribe((response: any) => {
   
      console.log(response);

    this.SpinnerService.show(); 
   
    let resobj = JSON.parse(response); 
      if(resobj[0].status=='success'){  
          this.hideLeave();
          this.toastr.success(resobj[0].msg);
          this.leave_id =0;       
          this.ngOnInit();
          this.SpinnerService.hide();   
      }else{
        this.toastr.error(resobj[0].msg);     
        this.SpinnerService.hide();                
      }
    }, 
    (error: any) => {
    console.log(error);
    });

 }

 editLeaveApply(id:any){
  this.peopleService.getLeavedetails({params:{
    id:id}}).subscribe((response: any) => {
    this.SpinnerService.show();  
        let resobj =response; 
            if(resobj[0].status=='success'){  
                this.toastr.success(resobj[0].msg);
              
                const [year, month, day] =  resobj[0]['leave'][0].start_date.split('-');
                const obj = { year: parseInt(year), month: parseInt(month), day:parseInt(day.split(' ')[0].trim()) };
                this.leave_start_date= obj;

                const [year1, month1, day1] =  resobj[0]['leave'][0].end_date.split('-');
                const obj1 = { year: parseInt(year1), month: parseInt(month1), day:parseInt(day1.split(' ')[0].trim()) };
                this.leave_end_date= obj1;

                this.leave_type = resobj[0]['leave'][0].leave_type;
                this.leave_id =  resobj[0]['leave'][0].id;
                
                this.SpinnerService.hide();   
                
            }else{
             // this.toastr.error(resobj[0].msg);      
              this.leave_id =0;            
            }
            this.SpinnerService.hide();   
    }, 
    (error: any) => {
    console.log(error);
    });    
 }

 deleteLeaveApply(id:any){
  if(confirm("Are you sure to delete this Leave Apply?")){
      let  data_str = JSON.stringify( {
         leave_id:id
         }); 
      this.peopleService.deleteLeaveApply(data_str).subscribe((response: any) => {
        this.SpinnerService.show(); 
        let resobj = JSON.parse(response); 
            if(resobj[0].status=='success'){  
                this.toastr.success(resobj[0].msg);
                this.SpinnerService.hide();   
                this.ngOnInit();
            }else{
              this.toastr.error(resobj[0].msg);     
              this.SpinnerService.hide();                
            }
        }, 
        (error: any) => {
        console.log(error);
        });
     
  }
 }


}
