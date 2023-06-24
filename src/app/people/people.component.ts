import {  Component, ComponentFactoryResolver, OnInit } from '@angular/core';
import { FormGroup, FormControl, FormArray, FormBuilder } from '@angular/forms'  

import {NgbDateStruct, NgbModal} from '@ng-bootstrap/ng-bootstrap';

import { LocationsService } from '../locations.service';
import { PeopleService } from '../people.service';

import { ScheduleService } from '../schedule.service';
import { IDropdownSettings } from 'ng-multiselect-dropdown';
import { HttpClient } from '@angular/common/http';

import { NgxSpinnerService } from "ngx-spinner";  
import { ToastrService } from 'ngx-toastr';

import { Router, ActivatedRoute, ParamMap } from '@angular/router';
import { ThirdPartyDraggable } from '@fullcalendar/interaction';



@Component({
  selector: 'app-people',
  templateUrl: './people.component.html',
  styleUrls: ['./people.component.css']
})
export class PeopleComponent implements OnInit {
  file_picture:any="";
  user :any ={};
  first_name:any;
  last_name:any;
  email:any;
  users_id : any;
  business:any;
  business_name:any;
  business_id:any;
  selected_users_id:any;

  
  searchText:any;
  people:any[]=[];
  defaultImg:string='';
  showSingleMemberModal:boolean=false;
  showMemberModal: boolean = false;
  showCSVModal: boolean = false;
  file_csv:any;
  showmodalPayroll: boolean = false;

  employee_start_date!: NgbDateStruct;
  date!: {year: number, month: number};

  areas:any;
  locations:any;
  employeement_type:any;
  pay_rate_type:any;
  weekday_rate:any;
  saterday_rate:any;
  sunday_rate:any;
  holiday_rate:any;
  hourly_rate:any;
  salary_type:any;
  overtime_rate:any;
  monday_rate:any;
  tuesday_rate:any;
  wednesday_rate:any;
  thrusday_rate:any;
  friday_rate:any;
  salary_amount:any;
  Payroll_ID:any;
  payroll_id:any='';
  payroll:any;
  stress_profile:any;
  employee:any={};

  pay_rate:any;
  Hourly: boolean = false;
  Hourly_1_5_x_Overtime: boolean = false;
  Salary: boolean = false;
  Hourly_44_h_1_5_x_Overtime: boolean = false;
  Rates_per_Day: boolean = false;

  leave_start_date!: NgbDateStruct;
  leave_end_date!: NgbDateStruct;
  leave_type:any;
  
  training_renewal_date!: NgbDateStruct;
  training_notes: any;
  training_type:any;

  unavailability_start_date:any;
  unavailability_start_time:any;
  unavailability_end_date:any;
  unavailability_end_time:any;
  unavailability_repeat_type:any='Do not repeat';
  unavailability_repeat_date:any;

  unavailability_dayShow:boolean=false;
  unavailability_dateShow:boolean=false;

  unavailability_Mon:any;
  unavailability_Tue:any;
  unavailability_Wed:any;
  unavailability_Thu:any;
  unavailability_Fri:any;
  unavailability_Sat:any;
  unavailability_Sun:any;
  unavailability_notes:any;
  

  selected_tab:any=1;

  leave:any[]=[];
  training:any[]=[];
  unavailability:any[]=[];
  leave_id:any=0;
  training_id:any=0;
  unavailability_id:any=0;
  



  dropdownListMemLoc: any[]=[];
  selectedItemsMemLoc: any[]=[];
  dropdownSettingsMemLoc: IDropdownSettings ={};

  dropdownListMemLoc2: any[]=[];
  selectedItemsMemLoc2: any[]=[];
  dropdownSettingsMemLoc2: IDropdownSettings ={};

  dropdownListAccess: any[]=[];
  selectedItemsAccess: any[]=[];
  dropdownSettingsAccess: IDropdownSettings ={};


  dropdownListAccess1: any[]=[];
  selectedItemsAccess1: any[]=[];
  dropdownSettingsAccess1: IDropdownSettings ={};


  dropdownListLocation: any[]=[];
  selectedItemsLocation: any[]=[];
  dropdownSettingsLocation: IDropdownSettings ={};

  
  phone_no:any;

  name = 'Angular';  
  productForm2: FormGroup;  
 
 
  constructor(private peopleService:PeopleService,private scheduleService:ScheduleService,private httpClient: HttpClient,
    private modalService: NgbModal, private fb:FormBuilder,private locationsService:LocationsService,
    private SpinnerService:NgxSpinnerService,private toastr:ToastrService,
    private route: ActivatedRoute,
    private router: Router) {

    this.defaultImg = 'assets/images/circle-line-point-area-clip-art-png-favpng-CvaYhEcU64kWWSUQa3gVdNS78.jpg';

    this.productForm2 = this.fb.group({  
      name: 'Member',  
      quantities2: this.fb.array([]) ,  
    });  

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

    if(localStorage.getItem('business')){      
      let businesss_json:any = localStorage.getItem('business');
      this.business =  JSON.parse(businesss_json); 
      this.business_id = this.business.id;
   }
   else{
       alert("Your business is not selected.Please select a business from profile");
       this.router.navigate(['/dashboard', { }])

   }

    this.SpinnerService.show();  
    this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
      console.log(res);
      this.people = res;
      this.SpinnerService.hide();  
    });

    this.locationsService.getLocations({params:{users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{
      this.dropdownListMemLoc = [];
      for(let i=0;i<res.length;i++){
        this.dropdownListMemLoc.push( { item_id: res[i].id, item_text:  res[i].location_name });
       }
      this.selectedItemsMemLoc = [];
      this.dropdownSettingsMemLoc= {
      singleSelection: true,
      idField: 'item_id',
      textField: 'item_text',
     // selectAllText: 'Select All',
     // unSelectAllText: 'UnSelect All',
      itemsShowLimit: 1,
      allowSearchFilter: true 
      }

      this.dropdownListMemLoc2 = [];
      for(let i=0;i<res.length;i++){
        this.dropdownListMemLoc2.push( { item_id: res[i].id, item_text:  res[i].location_name });
       }
      this.selectedItemsMemLoc2 = [];
      this.dropdownSettingsMemLoc2= {
      singleSelection: true,
      idField: 'item_id',
      textField: 'item_text',
     // selectAllText: 'Select All',
     // unSelectAllText: 'UnSelect All',
      itemsShowLimit: 1,
      allowSearchFilter: true 
      }

    
    });

    this.peopleService.getUsersAccessLevel().subscribe((res: any[])=>{
      this.dropdownListAccess = [];
      for(let i=0;i<res.length;i++){
        this.dropdownListAccess.push( { item_id: res[i], item_text:  res[i] });
       }
      this.selectedItemsAccess = [];
      this.selectedItemsAccess1 = [];
      this.dropdownSettingsAccess= {
      singleSelection: true,
      idField: 'item_id',
      textField: 'item_text',
     // selectAllText: 'Select All',
     // unSelectAllText: 'UnSelect All',
      itemsShowLimit: 1,
      allowSearchFilter: true 
      }
    
    });

    this.scheduleService.getArea().subscribe((res: any[])=>{
      this.areas = res;
    });


    //Areas - Department
    this.locationsService.getAllAreasOfBusiness({params:{users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{
      this.dropdownListLocation = [];
      for(let i=0;i<res.length;i++){
        this.dropdownListLocation.push( { item_id: res[i].id, item_text:  res[i].area_name });
       }
      this.selectedItemsLocation = [];
      this.dropdownSettingsLocation= {
      singleSelection: false,
      idField: 'item_id',
      textField: 'item_text',
     // selectAllText: 'Select All',
     // unSelectAllText: 'UnSelect All',
      itemsShowLimit: 5,
      allowSearchFilter: true 
      }
    });



  }

  payRate(){
    if(this.pay_rate_type=='Hourly'){
      this.Hourly= true;
      this.Hourly_1_5_x_Overtime = false;
      this.Salary= false;
      this.Hourly_44_h_1_5_x_Overtime = false;
      this.Rates_per_Day = false;
    }
    else if(this.pay_rate_type=='Hourly (1.5 x Overtime)'){
      this.Hourly= false;
      this.Hourly_1_5_x_Overtime = true;
      this.Salary= false;
      this.Hourly_44_h_1_5_x_Overtime = false;
      this.Rates_per_Day = false;

    }else if(this.pay_rate_type=='Salary'){
      this.Hourly= false;
      this.Hourly_1_5_x_Overtime = false;
      this.Salary= true;
      this.Hourly_44_h_1_5_x_Overtime = false;
      this.Rates_per_Day = false;

    }else if(this.pay_rate_type=='Hourly (44 h + 1.5 x Overtime)'){
      this.Hourly= false;
      this.Hourly_1_5_x_Overtime = false;
      this.Salary= false;
      this.Hourly_44_h_1_5_x_Overtime = true;
      this.Rates_per_Day = false;

    }else if(this.pay_rate_type=='Rates per Day'){
      this.Hourly= false;
      this.Hourly_1_5_x_Overtime = false;
      this.Salary= false;
      this.Hourly_44_h_1_5_x_Overtime = false;
      this.Rates_per_Day = true;

    }
  }

  onItemSelect(item: any) {
    console.log(item);
  }
  onSelectAll(items: any) {
    console.log(items);
  }


  ////////////////Member////////////
  showSingleModal(){
    this.showSingleMemberModal = true;
    this.selected_users_id ='';
  }

  hideSingleMember(){
    this.showSingleMemberModal = false;
    }

    
/*
* save single member
*/
saveSingleMember(){    
   if(typeof this.first_name=='undefined' || this.first_name==''){
    this.toastr.error('First Name is a required field');      
    return;
   }
   if(typeof this.last_name=='undefined' || this.last_name==''){
    this.toastr.error('Last Name is a required field');    
    return;  
   }
   if(typeof this.selectedItemsMemLoc[0]=='undefined' ||  this.selectedItemsMemLoc[0]==''){
    this.toastr.error('Location is a required field');      
    return;
   }
   if(typeof this.phone_no=='undefined' ||  this.phone_no==''){
    this.toastr.error('Phone No is a required field');      
    return;
   }
   if( typeof this.email=='undefined' ||  this.email==''){
    this.toastr.error('Email is a required field');    
    return;  
   }
   if( typeof this.selectedItemsAccess[0]=='undefined' ||  this.selectedItemsAccess[0]==''){
    this.toastr.error('Access is a required field');     
    return;
   }

  let data_str = JSON.stringify( { 
           first_name:this.first_name,
           last_name:      this.last_name,
           main_location_id:      this.selectedItemsMemLoc[0].item_id,
           main_location:      this.selectedItemsMemLoc[0].item_text,
           phone_no:      this.phone_no,
           email:      this.email,
           user_type:      this.selectedItemsAccess[0].item_id,
           users_id:this.selected_users_id,
           business_id:this.business_id
       });


  this.peopleService.saveSingleUser(data_str).subscribe( (response: any) => {
            this.SpinnerService.show();  
              console.log(response);
             let resobj = JSON.parse( response); 
                if(resobj[0].status=='success'){  
                    this.toastr.success(resobj[0].msg);
                    this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
                    this.people = res;        
                    this.hideSingleMember();            
                   });
                }else{
                  this.toastr.error(resobj[0].msg);                  
                }
                this.SpinnerService.hide();   
             }, 
            (error: any) => {
             console.log(error);
             this.SpinnerService.hide();   
           });
     this.selected_users_id ='';      
 
}

updateTeamMember(users_id:any){
  
  this.showSingleMemberModal = true;

  this.peopleService.getMemberdetails({params:{id:users_id}}).subscribe((response: any) => {
    this.SpinnerService.show();  
    let resobj =response; 
    console.log(response);
        if(resobj[0].status=='success'){  
            this.toastr.success(resobj[0].msg);
            this.first_name = resobj[0]['user'][0].first_name;
            this.last_name = resobj[0]['user'][0].last_name;
            this.selectedItemsMemLoc = [{ item_id: resobj[0]['user'][0].main_location_id,item_text:resobj[0]['user'][0].main_location} ];
            this.phone_no = resobj[0]['user'][0].phone_no;
            this.email =  resobj[0]['user'][0].email;
            this.selectedItemsAccess = [{ item_id:resobj[0]['user'][0].user_type,item_text:resobj[0]['user'][0].user_type} ];
            this.selected_users_id = resobj[0]['user'][0].id;
          
        }else{
          this.toastr.error(resobj[0].msg);                  
        }
        this.SpinnerService.hide();   
    }, 
    (error: any) => {
    console.log(error);
    this.SpinnerService.hide();   
  });
   
}

archiveTeamMember(id:any){
  if(confirm("Are you sure to send him to archive?This person will be invisible.")){
      this.peopleService.archiveTeamMember({params:{users_id:id,business_id:this.business_id}}).subscribe((response: any) => {
                  this.SpinnerService.show();  
                let resobj =response; 
                    if(resobj[0].status=='success'){  
                        this.toastr.success(resobj[0].msg);
                        this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
                        this.people = res;        
                        this.hideSingleMember();            
                      });
                    }else{
                      this.toastr.error(resobj[0].msg);                  
                    }
                    this.SpinnerService.hide();   
                }, 
                (error: any) => {
                console.log(error);
                this.SpinnerService.hide();   
              });
    }
}
 ////////////////Member////////////   


////////////////////////Multiple Member//////////////////////////////

showMember(){
  this.showMemberModal = true;
  this.addQuantity2();
}

hideMember(){
  this.showMemberModal = false;  
  }

  /*
  onItemSelect(item: any) {
    console.log(item);
  }
  onSelectAll(items: any) {
    console.log(items);
  }*/


  quantities2() : FormArray {  
    return this.productForm2.get("quantities2") as FormArray  
  }  
     
  newQuantity2(): FormGroup {  
    return this.fb.group({  
      first_name: '',  
      last_name: '',  
      email: '',  
      phone_no: '',  
    })  
  }  
  
  newDynamicQuantity2(obj:any): FormGroup {  
    return this.fb.group({  
      first_name: obj.first_name,  
      last_name: obj.last_name,  
      email: obj.email,  
      phone_no: obj.phone_no, 
    })  
  } 
     
  addQuantity2() {  
    this.quantities2().push(this.newQuantity2());  
    this.quantities2().push(this.newQuantity2());
    this.quantities2().push(this.newQuantity2());
  }  
     
  removeQuantity2(i:number) {  
    this.quantities2().removeAt(i);  
  }  
  /*
  *save multiple member
  */
  saveMultipleMember(){
   
    let data_str = JSON.stringify( { 
             members:this.quantities2().value,
             main_location_id:   this.selectedItemsMemLoc[0].item_id,
             main_location:   this.selectedItemsMemLoc[0].item_text,
             user_type: 'Employee',
             business_id:this.business_id
         });
  
  
    this.peopleService.saveMultiUsers(data_str).subscribe( (response: any) => {
              console.log(response);
              this.SpinnerService.show();  
               let resobj = JSON.parse( response); 
                  if(resobj[0].status=='success'){  
                      this.toastr.success(resobj[0].msg);
                      this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
                      this.people = res;        
                      this.hideMember();            
                     });
                  }else{
                    this.toastr.error(resobj[0].msg);                  
                  }
                  this.SpinnerService.hide();   
               }, 
              (error: any) => {
               console.log(error);
               this.SpinnerService.hide();   
             });
  }
////////////////////////Multiple Member//////////////////////////////


////////////////////////CSV//////////////////////////////
showModalCSV(){
   this.showCSVModal = true;
}

hidecsv(){
  this.showCSVModal = false;
}

myForm = new FormGroup({
  name: new FormControl('', []),
  file: new FormControl('', []),
  fileSource: new FormControl('', [])
});

onFileChange(event:any) {
   
  if (event.target.files.length > 0) {

    if(event.target.files[0].type!='text/csv')
    {
      alert("Please select csv file");
      return;
    }

    const file = event.target.files[0];
    this.myForm.patchValue({
      fileSource: file
    });
  }
} 

uploadCSV(){

  if(typeof this.selectedItemsMemLoc2[0]=='undefined' ||  this.selectedItemsMemLoc2[0]==''){
    this.toastr.error('Location is a required field');      
    return;
   }
  if(this.myForm.get('fileSource')?.value==""){
    this.toastr.error("Please select a csv file");
      return;
  }

  const formData = new FormData();
  formData.append('file_csv', this.myForm.get('fileSource')?.value);

  formData.append('main_location_id', this.selectedItemsMemLoc2[0].item_id);
  formData.append('main_location', this.selectedItemsMemLoc2[0].item_text);
  formData.append('users_id', this.selected_users_id);
  formData.append('business_id', this.business_id);

  this.peopleService.uploadCSV(formData).subscribe( (response: any) => {
            this.SpinnerService.show();  
             let resobj = JSON.parse( response); 
                if(resobj[0].status=='success'){  
                    this.toastr.success(resobj[0].msg);
                    this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
                    this.people = res;        
                    this.hidecsv();    
                   });
                }else{
                  this.toastr.error(resobj[0].msg);                  
                }
                this.SpinnerService.hide();   
             }, 
            (error: any) => {
             console.log(error);
             this.SpinnerService.hide();   
           });
     this.selected_users_id ='';      
}

//Leave

//Leave
showCSVLeaveModal:boolean=false;
file_employee_csv:any;
showModalLeaveCSV(){
  this.showCSVLeaveModal = true;
}

hideLeavecsv(){
 this.showCSVLeaveModal = false;
}

myForm3 = new FormGroup({
 name: new FormControl('', []),
 file: new FormControl('', []),
 fileSource: new FormControl('', [])
});

onFileChange3(event:any) {
  
 if (event.target.files.length > 0) {

   if(event.target.files[0].type!='text/csv')
   {
     alert("Please select csv file");
     return;
   }

   const file = event.target.files[0];
   this.myForm3.patchValue({
     fileSource: file
   });
 }
} 

downloadLeaveCSVFormat(){

  const formData = new FormData();
  formData.append('users_id', this.users_id);
  formData.append('business_id', this.business_id);
 
  this.peopleService.downloadLeaveCSVFormat(formData).subscribe( (response: any) => {
            const blob = new Blob([response], { type: 'text/csv' });
            const url= window.URL.createObjectURL(blob);
            window.open(url);
             }, 
            (error: any) => {
             console.log(error);
             this.SpinnerService.hide();   
           });
}

uploadLeaveCSV(){

 if(this.myForm3.get('fileSource')?.value==""){
   this.toastr.error("Please select a csv file");
     return;
 }

 const formData = new FormData();
 formData.append('file_employee_csv', this.myForm3.get('fileSource')?.value);
 formData.append('users_id', this.users_id);
 formData.append('business_id', this.business_id);

 this.peopleService.uploadLeaveCSV(formData).subscribe( (response: any) => {
           this.SpinnerService.show();  
            let resobj = JSON.parse( response); 
               if(resobj[0].status=='success'){  
                   this.toastr.success(resobj[0].msg);
                   this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
                   this.people = res;        
                   this.hideLeavecsv();    
                  });
               }else{
                 this.toastr.error(resobj[0].msg);                  
               }
               this.SpinnerService.hide();   
            }, 
           (error: any) => {
            console.log(error);
            this.SpinnerService.hide();   
          });
}
////////////////////////CSV//////////////////////////////


////////////////////////Employee PayRoll//////////////////////////////
showPayroll(selected_users_id:any,user:any){

  this.Payroll_ID='';
  //this.employee_start_date = '';
  this.stress_profile='';
  this.employeement_type='';
  this.pay_rate_type='';
  this.salary_type='';
  this.salary_amount='';
  this.weekday_rate='';
  this.holiday_rate='';
  this.saterday_rate='';
  this.sunday_rate='';
  this.monday_rate='';
  this.tuesday_rate='';
  this.wednesday_rate='';
  this.thrusday_rate='';
  this.friday_rate='';
  this.hourly_rate='';
  this.overtime_rate='';

  this.employee = user;
  this.selected_users_id = selected_users_id;
  this.showmodalPayroll = true;
  this.editPayroll(this.selected_users_id);
}

hidePayroll(){
 this.showmodalPayroll = false;
 window.location.reload(); 
}

/*
getPayroll(){
this.SpinnerService.show();   
this.peopleService.getPayroll({params:{users_id:this.users_id,
  business_id:this.business_id}}).subscribe((res: any[])=>{
  this.payroll = res;
  this.SpinnerService.hide();   
  });
  }*/
savePayroll(){  
    
      let  data_str = JSON.stringify( {
                super_users_id:this.users_id,
                selected_users_id:this.selected_users_id,
                business_id:this.business_id,
                Payroll_ID:this.Payroll_ID,
                access_level:this.selectedItemsAccess1[0].item_id,
                stress_profile:this.stress_profile,
                employee_start_date:this.employee_start_date.year+'-'+this.employee_start_date.month +'-'+this.employee_start_date.day,
                employeement_type:this.employeement_type,
                pay_rate_type:this.pay_rate_type,
                salary_type:this.salary_type,
                salary_amount:this.salary_amount,
                weekday_rate:this.weekday_rate, 
                public_holiday_rate:this.holiday_rate,
                saterday_rate:this.saterday_rate,
                sunday_rate:this.sunday_rate,
                monday_rate:this.monday_rate,
                tuesday_rate:this.tuesday_rate,
                wednesday_rate:this.wednesday_rate,
                thrusday_rate:this.thrusday_rate,
                friday_rate:this.friday_rate,
                hourly_rate:this.hourly_rate,
                overtime_rate:this.overtime_rate,
                location:this.selectedItemsLocation,               
                payroll_id:this.payroll_id             
        
     });

    this.peopleService.savePayroll(data_str).subscribe((response: any) => {
      this.SpinnerService.show(); 
      let resobj = JSON.parse(response); 
          if(resobj[0].status=='success'){  
              this.toastr.success(resobj[0].msg);
              this.hidePayroll();
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
editPayroll(selected_users_id:any){
    this.peopleService.getPayroll({params:{
      selected_users_id:selected_users_id,
      users_id:this.users_id,
      business_id:this.business_id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
          let resobj =response; 
              if(resobj[0].status=='success'){  
                  this.toastr.success(resobj[0].msg);
                  this.Payroll_ID= resobj[0]['payroll'][0].Payroll_ID;
                  this.selectedItemsAccess1 = [{ item_id: resobj[0]['payroll'][0].access_level,item_text:resobj[0]['payroll'][0].access_level} ];
                  const [year, month, day] =  resobj[0]['payroll'][0].employee_start_date.split('-');
                  const obj = { year: parseInt(year), month: parseInt(month), day:parseInt(day.split(' ')[0].trim()) };
                  this.employee_start_date= obj;
                  this.stress_profile = resobj[0]['payroll'][0].stress_profile;
                  this.employeement_type= resobj[0]['payroll'][0].employeement_type;
                  this.pay_rate_type= resobj[0]['payroll'][0].pay_rate_type;
                  this.salary_type= resobj[0]['payroll'][0].salary_type;
                  this.salary_amount= resobj[0]['payroll'][0].salary_amount;
                  this.weekday_rate= resobj[0]['payroll'][0].weekday_rate;
                  this.holiday_rate= resobj[0]['payroll'][0].public_holiday_rate;
                  this.saterday_rate= resobj[0]['payroll'][0].saterday_rate;
                  this.sunday_rate= resobj[0]['payroll'][0].sunday_rate;
                  this.monday_rate= resobj[0]['payroll'][0].monday_rate;
                  this.tuesday_rate= resobj[0]['payroll'][0].tuesday_rate;
                  this.wednesday_rate= resobj[0]['payroll'][0].wednesday_rate;
                  this.thrusday_rate= resobj[0]['payroll'][0].thrusday_rate;
                  this.friday_rate= resobj[0]['payroll'][0].friday_rate;
                  this.hourly_rate= resobj[0]['payroll'][0].hourly_rate;
                  this.overtime_rate= resobj[0]['payroll'][0].overtime_rate;
                  // 
                  let arrData:any[] = [];
                  resobj[0]['location'].forEach((element: any) => {
                    arrData.push({ item_id: element.location_id,item_text:element.location_name});
                  });

                  this.selectedItemsLocation=arrData;

                  this.leave = resobj[0]['leave'];
                  this.training = resobj[0]['training'];
                  this.unavailability = resobj[0]['unavailability'];

                  this.payroll_id = resobj[0]['payroll'][0].id;
                  this.payRate();   
                  this.repeatTypeChange();               
                  
                  this.SpinnerService.hide();   
                  
              }else{
               // this.toastr.error(resobj[0].msg);      
                this.payroll_id ='';            
              }
              this.SpinnerService.hide();   
      }, 
      (error: any) => {
      console.log(error);
      }); 
  
   }
  
   deletePayroll(area_id:any){
    if(confirm("Are you sure to delete this area?")){
    let  data_str = JSON.stringify( {
        users_id:this.users_id,
        business_id:this.business_id,
        location_id:this.route.snapshot.params['id'],
        area_id:area_id
       }); 
    this.peopleService.deletePayroll(data_str).subscribe((response: any) => {
      this.SpinnerService.show(); 
      let resobj = JSON.parse(response); 
          if(resobj[0].status=='success'){  
              this.toastr.success(resobj[0].msg);
              //this.getPayroll();
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
   }

   
   tabButton(tab:any){
    this.selected_tab=tab;
   }
   

   saveLeave(){
      let  data_str = JSON.stringify( {
        start_date:this.leave_start_date.year+'-'+this.leave_start_date.month +'-'+this.leave_start_date.day,
        end_date:this.leave_end_date.year+'-'+this.leave_end_date.month +'-'+this.leave_end_date.day,
        leave_type:this.leave_type,
        payroll_id:this.payroll_id,
        leave_id:this.leave_id             

      });

      this.peopleService.saveLeave(data_str).subscribe((response: any) => {
      this.SpinnerService.show(); 
     
      let resobj = JSON.parse(response); 
        if(resobj[0].status=='success'){  
            
            this.toastr.success(resobj[0].msg);
            this.editPayroll(this.selected_users_id);
            this.leave_id =0;       
            
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

   editLeave(id:any){
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

   deleteLeave(id:any){
    if(confirm("Are you sure to delete this Leave?")){
        let  data_str = JSON.stringify( {
           leave_id:id
           }); 
        this.peopleService.deleteLeave(data_str).subscribe((response: any) => {
          this.SpinnerService.show(); 
          let resobj = JSON.parse(response); 
              if(resobj[0].status=='success'){  
                  this.toastr.success(resobj[0].msg);
                  this.editPayroll(this.selected_users_id);
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
   }

   saveTraining(){
    let  data_str = JSON.stringify( {
      training_type:this.training_type,
      renewal_date:this.training_renewal_date.year+'-'+this.training_renewal_date.month +'-'+this.training_renewal_date.day,
      notes:this.training_notes,
      payroll_id:this.payroll_id,
      training_id:this.training_id             

    });

    this.peopleService.saveTraining(data_str).subscribe((response: any) => {
    this.SpinnerService.show(); 
   
    let resobj = JSON.parse(response); 
      if(resobj[0].status=='success'){  
          
          this.toastr.success(resobj[0].msg);

          this.editPayroll(this.selected_users_id);

          this.training_id =0;       
          
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


  editTraining(id:any){
    this.peopleService.getTrainingdetails({params:{
      id:id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
          let resobj =response; 
              if(resobj[0].status=='success'){  
                  this.toastr.success(resobj[0].msg);

                
                  const [year, month, day] =  resobj[0]['training'][0].renewal_date.split('-');
                  const obj = { year: parseInt(year), month: parseInt(month), day:parseInt(day.split(' ')[0].trim()) };
                  this.training_renewal_date= obj;

                  this.training_type = resobj[0]['training'][0].training_type;

                  this.training_notes = resobj[0]['training'][0].notes;
                  this.training_id =  resobj[0]['training'][0].id;
                  
                  this.SpinnerService.hide();   
                  
              }else{
               // this.toastr.error(resobj[0].msg);      
                this.training_id =0;            
              }
              this.SpinnerService.hide();   
      }, 
      (error: any) => {
      console.log(error);
      });    

  }

  deleteTraining(id:any){
   if(confirm("Are you sure to delete this Training?")){
    let  data_str = JSON.stringify( {
      training_id:id
      }); 
   this.peopleService.deleteTraining(data_str).subscribe((response: any) => {
     this.SpinnerService.show(); 
     let resobj = JSON.parse(response); 
         if(resobj[0].status=='success'){  
             this.toastr.success(resobj[0].msg);
             this.editPayroll(this.selected_users_id);
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
  }
  


  repeatTypeChange(){    
    this.unavailability_dayShow = false;
    this.unavailability_dateShow= false;

    

    if(this.unavailability_repeat_type=='Do not repeat'){
      this.unavailability_dateShow= true;
    }else {
      this.unavailability_dayShow= true;    

      this.unavailability_start_date = '';
      this.unavailability_end_date  = '';
      this.unavailability_start_date  = '';
      this.unavailability_end_date  = '';
    }
  } 
  
  saveUnavailability(){
    let start_date='';


    if(typeof this.unavailability_start_date!='undefined'){

      
      start_date = this.unavailability_start_date.year+'-'+this.unavailability_start_date.month +'-'+this.unavailability_start_date.day;
    }
     let end_date ='';
     if(typeof this.unavailability_end_date!='undefined'){
       end_date= this.unavailability_end_date.year+'-'+this.unavailability_end_date.month +'-'+this.unavailability_end_date.day;
     }
     let  data_str = JSON.stringify( {
      start_date:start_date,
      start_time:this.unavailability_start_time,
      end_date:end_date,
      end_time:this.unavailability_end_time,
      repeat_type:this.unavailability_repeat_type,
      Mon:this.unavailability_Mon,
      Tue:this.unavailability_Tue,
      Wed:this.unavailability_Wed,
      Thu:this.unavailability_Thu,
      Fri:this.unavailability_Fri,
      Sat:this.unavailability_Sat,
      Sun:this.unavailability_Sun,
      notes:this.unavailability_notes,
      payroll_id:this.payroll_id,
      unavailability_id:this.unavailability_id  
    });



    this.peopleService.saveUnavailability(data_str).subscribe((response: any) => {
    this.SpinnerService.show(); 
    let resobj = JSON.parse(response); 
      if(resobj[0].status=='success'){            
          this.toastr.success(resobj[0].msg);
          this.editPayroll(this.selected_users_id);
          this.unavailability_id =0;                 
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


  editUnavailability(id:any){
    this.peopleService.getUnavailabilitydetails({params:{
      id:id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
          let resobj =response; 
              if(resobj[0].status=='success'){  
                  this.toastr.success(resobj[0].msg);

                
                  const [year, month, day] =  resobj[0]['unavailability'][0].start_date.split('-');
                  const obj = { year: parseInt(year), month: parseInt(month), day:parseInt(day.split(' ')[0].trim()) };
                  this.unavailability_start_date= obj;

                  this.unavailability_start_time= resobj[0]['unavailability'][0].start_time;

                  const [year1, month1, day1] =  resobj[0]['unavailability'][0].end_date.split('-');
                  const obj1 = { year: parseInt(year1), month: parseInt(month1), day:parseInt(day1.split(' ')[0].trim()) };
                  this.unavailability_end_date= obj1;

                  this.unavailability_end_time= resobj[0]['unavailability'][0].end_time;

                  this.unavailability_repeat_type= resobj[0]['unavailability'][0].repeat_type;
                  this.unavailability_Mon = resobj[0]['unavailability'][0].Mon;
                  this.unavailability_Tue = resobj[0]['unavailability'][0].Tue;
                  this.unavailability_Wed = resobj[0]['unavailability'][0].Wed;
                  this.unavailability_Thu = resobj[0]['unavailability'][0].Thu;
                  this.unavailability_Fri = resobj[0]['unavailability'][0].Fri;
                  this.unavailability_Sat = resobj[0]['unavailability'][0].Sat;
                  this.unavailability_Sun = resobj[0]['unavailability'][0].Sun;

                  this.unavailability_notes = resobj[0]['unavailability'][0].notes;

                  this.unavailability_id =  resobj[0]['unavailability'][0].id;

                  this.repeatTypeChange();
                  
                  this.SpinnerService.hide();   
                  
              }else{
               // this.toastr.error(resobj[0].msg);      
                this.unavailability_id =0;            
              }
              this.SpinnerService.hide();   
      }, 
      (error: any) => {
      console.log(error);
      });    

  }

  deleteUnavailability(id:any){
   if(confirm("Are you sure to delete this Unavailability?")){
    let  data_str = JSON.stringify( {
      unavailability_id:id
      }); 
   this.peopleService.deleteUnavailability(data_str).subscribe((response: any) => {
     this.SpinnerService.show(); 
     let resobj = JSON.parse(response); 
         if(resobj[0].status=='success'){  
             this.toastr.success(resobj[0].msg);
             this.editPayroll(this.selected_users_id);
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
  }
  
  //upload picture
  myForm1 = new FormGroup({
    name: new FormControl('', []),
    file: new FormControl('', []),
    fileSource: new FormControl('', [])
  });
  
  onFileChange1(event:any) {
     
    if (event.target.files.length > 0) {
  
      const file = event.target.files[0];
      this.myForm.patchValue({
        fileSource: file
      });
    }
  } 
  
  uploadPicture(users_id:any){
    
    if(this.myForm.get('fileSource')?.value==""){
      this.toastr.error("Please select a picture file");
        return;
    }

    const formData = new FormData();
    formData.append('file_picture', this.myForm.get('fileSource')?.value);
    formData.append('users_id', users_id);
    
  
    this.peopleService.uploadPicture(formData).subscribe( (response: any) => {
              this.SpinnerService.show();  
               let resobj = JSON.parse( response); 
                  if(resobj[0].status=='success'){  
                      this.toastr.success(resobj[0].msg);
                      this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
                      this.people = res;        
                     });
                  }else{
                    this.toastr.error(resobj[0].msg);                  
                  }
                  this.SpinnerService.hide();   
               }, 
              (error: any) => {
               console.log(error);
               this.SpinnerService.hide();   
             });
       this.selected_users_id ='';      
  }
  

////////////////////////Employee PayRoll//////////////////////////////


}
