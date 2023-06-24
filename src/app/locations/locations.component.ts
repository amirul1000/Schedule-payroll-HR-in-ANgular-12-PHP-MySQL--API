import { Component, OnInit } from '@angular/core';

import { LocationsService } from '../locations.service';
import { ScheduleService } from '../schedule.service';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';

import {LocationsDataComponent} from './locations.data';
import { IDropdownSettings } from 'ng-multiselect-dropdown';

import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from "ngx-spinner";  


// just an interface for type safety.
interface marker {
	lat: number;
	lng: number;
	label?: string;
	draggable: boolean;
}

@Component({
  selector: 'app-locations',
  templateUrl: './locations.component.html',
  styleUrls: ['./locations.component.css']
})
export class LocationsComponent implements OnInit {
  file_picture:any="";
  user :any ={};
  first_name:any;
  last_name:any;
  email:any;
  users_id : any;

  locations:any[]=[];  
  searchText:any;
  areas:any;
  newArea:any;
  durations:any[]=[];

  business:any;
  business_name:any;
  business_id:any;
  selected_business_id:any='';

  showLocationModal:boolean=false;
  location_id:any='';
  area_id:any='';

  week_start:any;
  ROSTER_DEFAULT_SHIFT_LEN:any;
  DEFAULT_MEALBREAK_DURATION:any;
  ROSTER_PREVENT_CHANGE_HOURS:any;
  ROSTER_NOTIFICATION_MANAGER:any;
  ROSTER_REQUIRE_CONFIRM_HOURS:any;
  NOTIFICATION_ON_SHIFT_REMOVED:any;
  ROSTER_RECOMMENDATION_SORTING:any;
  ROSTER_ALLOW_SMS_WITH_FULL_NAME:any;
  ROSTER_ALLOW_PEER_VIEW:any;
  ROSTER_ALLOW_SWAP_SHIFT:any;
  ROSTER_SWAP_REQUIRE_APPROVAL:any;
  ROSTER_ALLOW_OFFER_SHIFT:any;
  SHIFT_COST_ADDITIONAL:any;
  SHIFT_DEFAULT_COST:any;

  showSection1: boolean = true;
  showSection2: boolean = false;  
  showSection3: boolean = false;  

  location_name:any;
  location_code:any; 
  address:any;
  timezone:any; 
  monday:any; 
  monday_from:any; 
  monday_to:any; 
  tuesday:any; 
  tuesday_from:any; 
  tuesday_to:any; 
  wednesday:any; 
  wednesday_from:any; 
  wednesday_to:any; 
  thursday:any; 
  thursday_from:any; 
  thursday_to:any; 
  friday:any; 
  friday_from:any; 
  friday_to:any; 
  saturday:any; 
  saturday_from:any; 
  saturday_to:any; 
  sunday:any; 
  sunday_from:any; 
  sunday_to:any; 
  notes:any; 

  dropdownListTimeZone: any[]=[];
  selectedItemsTimeZone: any[]=[];
  dropdownSettingsTimeZone:IDropdownSettings ={};



  dropdownTimeListSat: any[]=[];
  selectedItemsTimeListSat: any[]=[];
  dropdownSettingsTimeListSat: IDropdownSettings ={};

  dropdownTimeListSat2: any[]=[];
  selectedItemsTimeListSat2: any[]=[];
  dropdownSettingsTimeListSat2: IDropdownSettings ={};


  dropdownTimeListSun: any[]=[];
  selectedItemsTimeListSun: any[]=[];
  dropdownSettingsTimeListSun: IDropdownSettings ={};

  dropdownTimeListSun2: any[]=[];
  selectedItemsTimeListSun2: any[]=[];
  dropdownSettingsTimeListSun2: IDropdownSettings ={};


  dropdownTimeListMon: any[]=[];
  selectedItemsTimeListMon: any[]=[];
  dropdownSettingsTimeListMon: IDropdownSettings ={};

  dropdownTimeListMon2: any[]=[];
  selectedItemsTimeListMon2: any[]=[];
  dropdownSettingsTimeListMon2: IDropdownSettings ={};


  dropdownTimeListTue: any[]=[];
  selectedItemsTimeListTue: any[]=[];
  dropdownSettingsTimeListTue: IDropdownSettings ={};

  dropdownTimeListTue2: any[]=[];
  selectedItemsTimeListTue2: any[]=[];
  dropdownSettingsTimeListTue2: IDropdownSettings ={};

  dropdownTimeListWed: any[]=[];
  selectedItemsTimeListWed: any[]=[];
  dropdownSettingsTimeListWed: IDropdownSettings ={};

  dropdownTimeListWed2: any[]=[];
  selectedItemsTimeListWed2: any[]=[];
  dropdownSettingsTimeListWed2: IDropdownSettings ={};

  dropdownTimeListThurs: any[]=[];
  selectedItemsTimeListThurs: any[]=[];
  dropdownSettingsTimeListThurs: IDropdownSettings ={};

  dropdownTimeListThurs2: any[]=[];
  selectedItemsTimeListThurs2: any[]=[];
  dropdownSettingsTimeListThurs2: IDropdownSettings ={};

  dropdownTimeListFri: any[]=[];
  selectedItemsTimeListFri: any[]=[];
  dropdownSettingsTimeListFri: IDropdownSettings ={};

  dropdownTimeListFri2: any[]=[];
  selectedItemsTimeListFri2: any[]=[];
  dropdownSettingsTimeListFri2: IDropdownSettings ={};

  lat: number = 51.673858;
  lng: number = 7.815982;
  type = 'satellite';
  color_code:any;
  
  constructor(private locationsService:LocationsService,
    private route: ActivatedRoute,
    private router: Router,
    private locationsDataComponent:LocationsDataComponent,
    private scheduleService:ScheduleService,
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
  
      let cmd = this.route.snapshot.params['cmd']; 
      if(cmd=='edit'){
        this.location_id = this.route.snapshot.params['id']; 
        this.editLocation(this.location_id);
        this.showSection1 = false;
        this.showSection2 = true;
      }
      /*else{
        this.showSection1 = true;
        this.showSection2 = false;
        this.showSection2 = true;
      }*/
      this.durations =  Array(17).fill(15,0).map((x,i)=>x*i); 
    }

  ngOnInit(): void {

   
      
   this.loadDropdownData(); 
   this.getLocations();
  }


  onItemSelect(item: any) {
    console.log(item);
  }
  onSelectAll(items: any) {
    console.log(items);
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
    
    this.dropdownTimeListSat = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListSat.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListSat = [];
    this.dropdownSettingsTimeListSat= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListSat2 = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListSat2.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListSat2 = [];
    this.dropdownSettingsTimeListSat2= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListSun = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListSun.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListSun = [];
    this.dropdownSettingsTimeListSun= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListSun2 = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListSun2.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListSun2 = [];
    this.dropdownSettingsTimeListSun2= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }


    this.dropdownTimeListMon = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListMon.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListMon = [];
    this.dropdownSettingsTimeListMon= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListMon2 = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListMon2.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListMon2 = [];
    this.dropdownSettingsTimeListMon2= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListTue = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListTue.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListTue = [];
    this.dropdownSettingsTimeListTue= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListTue2 = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListTue2.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListTue2 = [];
    this.dropdownSettingsTimeListTue2= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListWed = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListWed.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListWed = [];
    this.dropdownSettingsTimeListWed= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListWed2 = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListWed2.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListWed2 = [];
    this.dropdownSettingsTimeListWed2= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListThurs = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListThurs.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListThurs = [];
    this.dropdownSettingsTimeListThurs= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListThurs2 = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListThurs2.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListThurs2 = [];
    this.dropdownSettingsTimeListThurs2= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListFri = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListFri.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListFri = [];
    this.dropdownSettingsTimeListFri= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

    this.dropdownTimeListFri2 = [];
    for(let i=0;i<this.locationsDataComponent.timeList.length;i++){
      this.dropdownTimeListFri2.push( { item_id: this.locationsDataComponent.timeList[i].key, item_text: this.locationsDataComponent.timeList[i].value });
     }
    this.selectedItemsTimeListFri2 = [];
    this.dropdownSettingsTimeListFri2= {
    singleSelection: true,
    idField: 'item_id',
    textField: 'item_text',
   // selectAllText: 'Select All',
   // unSelectAllText: 'UnSelect All',
    itemsShowLimit: 1,
    allowSearchFilter: true 
    }

  }
  selectedUserTab = 1;
  tabs = [
    {
      name: 'General',
      key: 1,
      active: true
    },
     {
     name: 'Department',
     key: 2,
     active: false
   },
  {
     name: 'Scheduling',
     key: 3,
     active: false
   },
  /* {
     name: 'Timesheets',
     key: 4,
     active: false
   }*/
  ];
tabChange(selectedTab:any) {
    this.selectedUserTab = selectedTab.key;
    for (let tab of this.tabs) {
        if (tab.key === selectedTab.key) {
          tab.active = true;          
        }
         //else {
         // tab.active = false;
       // }
    }

    if(selectedTab.key==1){

    }else  if(this.selectedUserTab ==2){
      this.getAreas();
    }else  if(this.selectedUserTab ==3){
      this.editLocation(this.location_id);
      this.showSection1 = false;
      this.showSection2 = true;
    }

  }

 /***************
     location
  *******************/
  getLocations(){
    this.SpinnerService.show();   
    this.locationsService.getLocations({params:{users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{
      this.locations = res;
      this.SpinnerService.hide();   
    });
  }
 saveLocation(){
  if(typeof this.location_name=='undefined' || this.location_name==''){
    this.toastr.error('Location Name is a required field');      
    return;
   }

   if(typeof this.location_code=='undefined' || this.location_code==''){
    this.toastr.error('Location code is a required field');      
    return;
   }

   if(typeof this.address=='undefined' || this.address==''){
    this.toastr.error('Address is a required field');    
    return;  
   }
   if(typeof this.selectedItemsTimeZone[0]=='undefined' ||  this.selectedItemsTimeZone[0]==''){
    this.toastr.error('TimeZone is a required field');      
    return;
   }

    let  data_str = JSON.stringify( {
      users_id:this.users_id,
      business_id:this.business_id,
      location_name:this.location_name,
      location_code:this.location_code,
      address:this.address,
      time_zone: typeof this.selectedItemsTimeZone[0]!=='undefined'?this.selectedItemsTimeZone[0].item_id:'',
      monday:this.monday,
      monday_from: typeof this.selectedItemsTimeListMon[0]!=='undefined'? this.selectedItemsTimeListMon[0].item_id:'',
      monday_to: typeof this.selectedItemsTimeListMon2[0]!=='undefined'? this.selectedItemsTimeListMon2[0].item_id:'',
      tuesday:this.tuesday,
      tuesday_from:typeof this.selectedItemsTimeListTue[0]!=='undefined'? this.selectedItemsTimeListTue[0].item_id:'',
      tuesday_to:typeof this.selectedItemsTimeListTue2[0]!=='undefined'?this.selectedItemsTimeListTue2[0].item_id:'',
      wednesday:this.wednesday,
      wednesday_from:typeof this.selectedItemsTimeListWed[0]!=='undefined'?this.selectedItemsTimeListWed[0].item_id:'',
      wednesday_to:typeof this.selectedItemsTimeListWed2[0]!=='undefined'?this.selectedItemsTimeListWed2[0].item_id:'',
      thursday:this.thursday,
      thursday_from:typeof this.selectedItemsTimeListThurs[0]!=='undefined'?this.selectedItemsTimeListThurs[0].item_id:'',
      thursday_to:typeof this.selectedItemsTimeListThurs2[0]!=='undefined'?this.selectedItemsTimeListThurs2[0].item_id:'',
      friday:this.friday,
      friday_from:typeof this.selectedItemsTimeListFri[0]!=='undefined'?this.selectedItemsTimeListFri[0].item_id:'',
      friday_to:typeof this.selectedItemsTimeListFri2[0]!=='undefined'?this.selectedItemsTimeListFri2[0].item_id:'',
      saturday:this.saturday,
      saturday_from:typeof this.selectedItemsTimeListSat[0]!=='undefined'?this.selectedItemsTimeListSat[0].item_id:'',
      saturday_to:typeof this.selectedItemsTimeListSat2[0]!=='undefined'?this.selectedItemsTimeListSat2[0].item_id:'',
      sunday:this.sunday,
      sunday_from:typeof this.selectedItemsTimeListSun[0]!=='undefined'?this.selectedItemsTimeListSun[0].item_id:'',
      sunday_to:typeof this.selectedItemsTimeListSun2[0]!=='undefined'?this.selectedItemsTimeListSun2[0].item_id:'',
      notes:this.notes,
      location_id:this.location_id
   });
  

  this.locationsService.saveLocation(data_str).subscribe((response: any) => {
    this.SpinnerService.show(); 
    let resobj = JSON.parse(response); 
        if(resobj[0].status=='success'){  
            this.toastr.success(resobj[0].msg);
            this.getLocations();
            this.hideLocation();
            this.location_id = this.route.snapshot.params['id'];
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
 editLocation(id:any){
  this.location_id = id;

  this.locationsService.getLocation({params:{users_id:this.users_id,business_id:this.business_id,location_id:this.location_id}}).subscribe((response: any) => {
    this.SpinnerService.show();  
        let resobj =response; 
            if(resobj[0].status=='success'){  
                this.toastr.success(resobj[0].msg);
                
                this.location_name  = resobj[0]['location'][0].location_name;
                this.location_code = resobj[0]['location'][0].location_code;
                this.address = resobj[0]['location'][0].address;
                this.selectedItemsTimeZone = resobj[0]['location'][0].timezone.length>0? [{ item_id: resobj[0]['location'][0].timezone,item_text:resobj[0]['location'][0].timezone} ]:[];
                
               if(this.location_id>0){
                this.monday=resobj[0]['location'][0].monday;
                this.selectedItemsTimeListMon= resobj[0]['location'][0].monday_from.length>0?[{ item_id: resobj[0]['location'][0].monday_from,item_text: resobj[0]['location'][0].monday_from}]:[];
                this.selectedItemsTimeListMon2=resobj[0]['location'][0].monday_to.length>0?[{ item_id: resobj[0]['location'][0].monday_to,item_text: resobj[0]['location'][0].monday_to}]:[];
                this.tuesday=resobj[0]['location'][0].tuesday;
                this.selectedItemsTimeListTue=resobj[0]['location'][0].tuesday_from.length>0?[{ item_id: resobj[0]['location'][0].tuesday_from,item_text: resobj[0]['location'][0].tuesday_from}]:[];
                this.selectedItemsTimeListTue2=resobj[0]['location'][0].tuesday_to.length>0?[{ item_id: resobj[0]['location'][0].tuesday_to,item_text: resobj[0]['location'][0].tuesday_to}]:[];
                this.wednesday=resobj[0]['location'][0].wednesday;
                this.selectedItemsTimeListWed=resobj[0]['location'][0].wednesday_from.length>0?[{ item_id: resobj[0]['location'][0].wednesday_from,item_text: resobj[0]['location'][0].wednesday_from}]:[];
                this.selectedItemsTimeListWed2=resobj[0]['location'][0].wednesday_to.length>0?[{ item_id: resobj[0]['location'][0].wednesday_to,item_text: resobj[0]['location'][0].wednesday_to}]:[];
                this.thursday=resobj[0]['location'][0].thursday;
                this.selectedItemsTimeListThurs=resobj[0]['location'][0].thursday_from.length>0?[{ item_id: resobj[0]['location'][0].thursday_from,item_text: resobj[0]['location'][0].thursday_from}]:[];
                this.selectedItemsTimeListThurs2=resobj[0]['location'][0].thursday_to.length>0?[{ item_id: resobj[0]['location'][0].thursday_to,item_text: resobj[0]['location'][0].thursday_to}]:[];
                this.friday=resobj[0]['location'][0].friday;
                this.selectedItemsTimeListFri=resobj[0]['location'][0].friday_from.length>0?[{ item_id: resobj[0]['location'][0].friday_from,item_text: resobj[0]['location'][0].friday_from}]:[];
                this.selectedItemsTimeListFri2=resobj[0]['location'][0].friday_to.length>0?[{ item_id: resobj[0]['location'][0].friday_to,item_text: resobj[0]['location'][0].friday_to}]:[];
                this.saturday=resobj[0]['location'][0].saturday;
                this.selectedItemsTimeListSat=resobj[0]['location'][0].saturday_from.length>0?[{ item_id: resobj[0]['location'][0].saturday_from,item_text: resobj[0]['location'][0].saturday_from}]:[];
                this.selectedItemsTimeListSat2=resobj[0]['location'][0].saturday_to.length>0?[{ item_id: resobj[0]['location'][0].saturday_to,item_text: resobj[0]['location'][0].saturday_to}]:[];
                this.sunday=resobj[0]['location'][0].sunday;
                this.selectedItemsTimeListSun=resobj[0]['location'][0].sunday_from.length>0?[{ item_id: resobj[0]['location'][0].sunday_from,item_text: resobj[0]['location'][0].sunday_from}]:[];
                this.selectedItemsTimeListSun2=resobj[0]['location'][0].sunday_to.length>0?[{ item_id: resobj[0]['location'][0].sunday_to,item_text: resobj[0]['location'][0].sunday_to}]:[];
                this.notes=resobj[0]['location'][0].notes;

                if(resobj[0]['location'][0].week_start){
                   this.week_start  = resobj[0]['location'][0].week_start;
                }
                if(resobj[0]['location'][0].ROSTER_DEFAULT_SHIFT_LEN){
                  this.ROSTER_DEFAULT_SHIFT_LEN  = resobj[0]['location'][0].ROSTER_DEFAULT_SHIFT_LEN;
                }
                if(resobj[0]['location'][0].DEFAULT_MEALBREAK_DURATION){
                  this.DEFAULT_MEALBREAK_DURATION  = resobj[0]['location'][0].DEFAULT_MEALBREAK_DURATION;
                }


                }

                this.location_id = resobj[0]['location'][0].id;
                
            }else{
              this.toastr.error(resobj[0].msg);                  
            }
            this.SpinnerService.hide();   
    }, 
    (error: any) => {
    console.log(error);
    }); 

 }

 deleteLocation(location_id:any){
  if(confirm("Are you sure to delete this location?")){
  let  data_str = JSON.stringify( {
      users_id:this.users_id,
      business_id:this.business_id,
      location_id:location_id
     }); 
  this.locationsService.deleteLocation(data_str).subscribe((response: any) => {
    this.SpinnerService.show(); 
    let resobj = JSON.parse(response); 
        if(resobj[0].status=='success'){  
            this.toastr.success(resobj[0].msg);
            this.getLocations();
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

 hideLocation(){
   this.location_id ='';    
  this.showLocationModal = false;
 }

 showLocation(){  
  this.showLocationModal = true;
}

  /***************
     Area
  *******************/
  getAreas(){
      this.SpinnerService.show();   
      this.locationsService.getAreas({params:{users_id:this.users_id,
        business_id:this.business_id,
        location_id:this.route.snapshot.params['id']}}).subscribe((res: any[])=>{
        this.areas = res;
        this.SpinnerService.hide();   
      });
    }
   saveArea(){
    if(typeof this.newArea=='undefined' || this.newArea==''){
      this.toastr.error('Area Name is a required field');      
      return;
     }
      let  data_str = JSON.stringify( {
        users_id:this.users_id,
        business_id:this.business_id,
        location_id:this.route.snapshot.params['id'],
        area_name:this.newArea,
        color_code:this.color_code,
        area_id:this.area_id
     });
    
  
    this.locationsService.saveArea(data_str).subscribe((response: any) => {
      this.SpinnerService.show(); 
      let resobj = JSON.parse(response); 
          if(resobj[0].status=='success'){  
              this.newArea = '';
              this.color_code = '';
              this.area_id = '';
              this.toastr.success(resobj[0].msg);
              this.getAreas();
              this.hideLocation();
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
   editArea(id:any){
    this.area_id = id;
  
    this.locationsService.getArea({params:{users_id:this.users_id,
      business_id:this.business_id,
      location_id:this.route.snapshot.params['id'],
      area_id:this.area_id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
          let resobj =response; 
              if(resobj[0].status=='success'){  
                  this.toastr.success(resobj[0].msg);
                  this.newArea  = resobj[0]['area'][0].area_name;
                  this.color_code = resobj[0]['area'][0].color_code;
                  this.area_id = resobj[0]['area'][0].id;
                  this.SpinnerService.hide();   
                  
              }else{
                this.toastr.error(resobj[0].msg);                  
              }
              this.SpinnerService.hide();   
      }, 
      (error: any) => {
      console.log(error);
      }); 
  
   }
  
   deleteArea(area_id:any){
    if(confirm("Are you sure to delete this area?")){
    let  data_str = JSON.stringify( {
        users_id:this.users_id,
        business_id:this.business_id,
        location_id:this.route.snapshot.params['id'],
        area_id:area_id
       }); 
    this.locationsService.deleteArea(data_str).subscribe((response: any) => {
      this.SpinnerService.show(); 
      let resobj = JSON.parse(response); 
          if(resobj[0].status=='success'){  
              this.toastr.success(resobj[0].msg);
              this.getAreas();
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

   saveShift(){
    let  data_str = JSON.stringify( {
      week_start:this.week_start,
      ROSTER_DEFAULT_SHIFT_LEN:this.ROSTER_DEFAULT_SHIFT_LEN,
      DEFAULT_MEALBREAK_DURATION: this.DEFAULT_MEALBREAK_DURATION,
      location_id:this.route.snapshot.params['id']
   });

    this.locationsService.saveShift(data_str).subscribe((response: any) => {
      this.SpinnerService.show(); 
      let resobj = JSON.parse(response); 
          if(resobj[0].status=='success'){  
            this.toastr.success(resobj[0].msg);
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
