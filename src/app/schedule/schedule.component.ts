import {  Component, OnInit, Input,ViewChild, ElementRef } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormGroup, FormControl, FormArray, FormBuilder } from '@angular/forms'  

import { CalendarOptions , DateSelectArg, EventClickArg, EventApi, FullCalendarComponent } from '@fullcalendar/angular';

import { FullCalendarModule } from '@fullcalendar/angular'; // must go before plugins


import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

import resourceTimelinePlugin from '@fullcalendar/resource-timeline'; // a plugin!
import interactionPlugin from '@fullcalendar/interaction';

import { LocationsService } from '../locations.service';
import { PeopleService } from '../people.service';

import {NgbDateStruct, NgbModal} from '@ng-bootstrap/ng-bootstrap';

import { ScheduleService } from '../schedule.service';
import { DatePipe } from '@angular/common';
import { IDropdownSettings } from 'ng-multiselect-dropdown';
import {ScheduleDataComponent} from './schedule.data';
import { auto } from '@popperjs/core';


import { NgxSpinnerService } from "ngx-spinner";  
import { ToastrService } from 'ngx-toastr';

import Swal from 'sweetalert2';


//import { toMoment, toMomentDuration } from '@fullcalendar/moment';
//import momentPlugin from '@fullcalendar/moment'


import * as $ from 'jquery';
import 'fullcalendar';
import * as moment from 'moment';

import { Calendar } from '@fullcalendar/core';
import { each } from 'jquery';
import { Element } from '@angular/compiler/src/render3/r3_ast';
import { ThisReceiver } from '@angular/compiler';


@Component({
  selector: 'app-schedule',
  templateUrl: './schedule.component.html',
  styleUrls: ['./schedule.component.css']
})




export class ScheduleComponent implements OnInit {
  // references the #calendar in the template
  @ViewChild('calendar') calendarComponent: FullCalendarComponent | undefined;  
  calendarApi:any;
    
  file_picture:any="";
  user :any ={};
  first_name:any;
  last_name:any;
  email:any;
  users_id : any;
  business:any;
  business_name:any;
  business_id:any;

  calendarOptions!: CalendarOptions;
  res:any;
  currentEvents: EventApi[] = [];


  showModal: boolean = false;
  showMemberModal: boolean = false;
  showSendOfferModal: boolean = false;

  content: any;
  title: any;


  assign_to_users_id:any;
  area:any;
  start:any;
  finish:any;
  meal_break:any;
  rest_break:any;
  notes:any;
  start_date:any;
  id:any;


  users_list: any ;
  area_list: any ;
  start_list : any;
  finish_list : any;
  meal_break_list: any;
  rest_break_list: any;

  cal_start_date: any;
  cal_end_date: any;


  area_selected:any;
  assign_by_users_id_selected:any;
  assign_to_users_id_selected:any;
  company_id_selected:any;
  finish_selected:any;
  meal_break_selected:any;
  notes_selected:any;
  rest_break_selected:any;
  start_selected:any;
  start_date_selected:any;
  more_detail_arr_selected:any;
  brkd_start_list:any;
  brkd_finish_list:any;
  brkd_start_selected:any;
  brkd_finish_selected:any;

  data_date_copied:any;
  data_resource_id_copied:any;
  id_copied:any=-1;
  id_invite : any =-1;

  name = 'Angular';  
  productForm: FormGroup;  
  productForm2: FormGroup;  

  polling: any;
  btnSaveText:any;
  more_detail:any;
  searchText:any;
  dataset:any[] = [];
  invite_users_list:any[] = []; 
  resources:any;
  resource_type:any="resource_by_member";
  cal_day_range:any=6;
  location_type:any='';
  location_id:any='';
  area_id:any='';
  total_unpublished:any=0;



  dropdownListMemLoc: any[]=[];
  selectedItemsMemLoc: any[]=[];
  dropdownSettingsMemLoc: IDropdownSettings ={};


  dropdownListScheLoc: any[]=[];
  selectedItemsScheLoc: any[]=[];
  dropdownSettingsScheLoc: IDropdownSettings ={};


  dropdownListScheWho: any[]=[];
  selectedItemsScheWho: any[]=[];
  dropdownSettingsScheWho: IDropdownSettings ={};


  dropdownListLoc: any[]=[];
  selectedItemsLoc: any[]=[];
  dropdownSettingsLoc: IDropdownSettings ={};
  location_area : any[]=[];



  defaultImg:string='';
  showeUserDetails: any[] = [];

  schedule_start_date!: NgbDateStruct;
  date!: {year: number, month: number};

  SelectedLocation:any="";

  email_option:any;
  sms_option:any;
  users_id_list :any[] = [];


// references the #calendar in the template
//@ViewChild('calendar') calendarComponent!: FullCalendarComponent ;


  constructor(private httpClient: HttpClient,
    private modalService: NgbModal,
    private scheduleService:ScheduleService,
    private peopleService:PeopleService,
    private fb:FormBuilder,
    private schudleData :ScheduleDataComponent,
    private elRef:ElementRef,
    private SpinnerService:NgxSpinnerService,
    private toastr:ToastrService) {

    let user_json:any = localStorage.getItem('user');
    this.user =  JSON.parse(user_json); 
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

   this.brkd_start_list=schudleData.brkd_start_list;
   this.brkd_finish_list=schudleData.brkd_finish_list;
    if(this.resource_type=='resource_by_member'){
      this.scheduleResourcesUsers();
    }
    else if(this.resource_type=='resource_by_area'){
      this.scheduleResourcesArea();
    }

    this.calendarApi = this.calendarComponent?.getApi();
   

      this.calendarOptions = {
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            initialView: "resourceTimeline",     
            /* headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth,resourceTimelineYear'
            },*/
            headerToolbar:false,
            editable: true,   
            scrollTime: '08:00',
            aspectRatio: 1.5,
          /* views: {
              resourceTimelineDay: {
              slotDuration: '01:00',   
              },    
            }, */
            views: {
              resourceTimelineSevenDay: {
              type: 'resourceTimeline',
              duration: { days: 7 }
             }   
           },      
         // resources: JSON.stringify(this.resources),
          /*  resources: [
                  {
                    id: "a",
                    title: "Phòng A"
                  },
                  {
                    id: "b",
                    title: "Phòng B"
                  },
                  {
                    id: "c",
                    title: "Phòng C"
                  }
                ],*/
              //  resources:'http://localhost/pm/index.php/server/serve?cmd=schedule_resources_users&business_id='+this.business_id,
            
            /* events: [
                  {
                    resourceId: "a",
                    title: "event 1",
                    data: {
                      full_name: "Nguyễn Hoàng Phúc",
                      date_of_birth: "28/09/1995",
                      gender: "Nam",
                      item_name: "Điều trị tủy răng và hàn kín hệ thống ống tủy bằng Gutta percha nguội (răng số 6, 7 hàm dưới)",
                      primary_sur_doctor_name: "Nguyễn Đăng Thu",
                      primary_anesthetic_doctor_name: "Bùi Trung Vang"
                    },
                    start: "2022-04-01 08:00",
                    end: "2022-04-01 10:30"
                  },
                  {
                    resourceId: "a",
                    title: "event 2",
                    start: "2022-04-01 10:30",
                    end: "2022-04-01 11:30",
                    color: "red"
                  },
                  {
                    resourceId: "c",
                    title: "event 3",
                    start: "2022-04-02 07:30",
                    end: "2022-04-04 12:00",
                    color: "blue"
                  }
                ],*/
                themeSystem: 'bootstrap5',
                contentHeight:'auto',   
                slotMinWidth:100,     
                resourceAreaWidth:'20%',
                slotEventOverlap: false,   
              // dateClick: this.onDateClick.bind(this),
              // weekends: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                windowResize: (arg)=>{this.ngAfterViewInit();},
              // select:this.handleDateSelect.bind(this),
              // eventClick: this.handleEventClick.bind(this),
              // eventsSet: this.handleEvents.bind(this), 
                eventDrop: (info) =>{
                  let datePipe = new DatePipe('en-US');
                  let date: Date = new Date(info.event.startStr);
                  let dropped_date  = datePipe.transform(date, 'yyyy-MM-dd');
                  if (!confirm("Are you sure about this change?")) {
                    info.revert();
                  }else{

                      ///////////////////////////////////////////
                      this.scheduleService.getScheduleDetail({params:{id:info.event.id}}).subscribe((response: any) => {

                        let param = {params:{
                              super_users_id:response[0]['super_users_id'],
                              business_id:response[0]['business_id'],
                              worker_users_id:info.event._def.resourceIds,
                              start:response[0]['start'],
                              finish:response[0]['finish'],
                              start_date:dropped_date,
                            }
                          };

                          this.scheduleService.checkOverlapping(param).subscribe((res: any[])=>{
                                let overlapping = res[0]['status']; 
                                
                                if(overlapping=='success' && this.resource_type=='resource_by_member'){
                                  info.revert();
                                  Swal.fire('Overlapping',res[0]['msg'],'error');
                                } 

                                if( this.resource_type=='resource_by_area'){
                                  overlapping = 'fail';
                               }
                        
                                if(overlapping=='fail'){
                        ////////////////////////////////////////    
                  
                          let data_str = JSON.stringify( {
                              id: info.event.id,
                              old_resource_id:info.oldEvent._def.resourceIds,   
                              new_resource_id:info.event._def.resourceIds,
                              dropped_date:dropped_date,
                              resource_type:this.resource_type,
                          });
                    
                          this.scheduleService.dargDropSchedule(data_str).subscribe( (response: any) => {
                                    let resobj = JSON.parse(response);
                                      if(resobj.status=='success'){
                                        this.loadSchedule();
                                      }
                                    }, 
                                  (error: any) => {
                                    console.log(error)
                                  }); 

                   ////////////////////////////////////////

                                }
                              });
                      
                            });
                  /////////////////////////////////////////////        
    

                  }

                },
                eventContent: function(_info) {
                },
            
                slotLaneContent:function(_info) {
          
                },
            
                dayCellDidMount: function(_info) {
          
                },
               
      };

      this.defaultImg = 'assets/images/circle-line-point-area-clip-art-png-favpng-CvaYhEcU64kWWSUQa3gVdNS78.jpg';
      this.getUsers();
     
      this.productForm = this.fb.group({  
        name: 'Schedule',  
        quantities: this.fb.array([]) ,  
      });  

      this.productForm2 = this.fb.group({  
        name: 'Member',  
        quantities2: this.fb.array([]) ,  
      });  

   }

   getUsers(){
    this.dataset = [];
    let param = {params:{
      business_id:this.business_id,      
      resource_type:this.resource_type,
      location_type:this.location_type,
      location_id:this.location_id,
      area_id:this.area_id,
      start_date:this.cal_start_date,
      end_date:this.cal_end_date
     }}; 
    this.scheduleService.getScheduleUsersPayroll(param).subscribe((res: any[])=>{
      this.dataset = res;
      for(let j=0;j<this.dataset.length;j++){         
        this.showeUserDetails[j] = false;
      }
    }); 
   }
   //Resources Users
   scheduleResourcesUsers(){
    let param = {params:{
      business_id:this.business_id,
      location_type:this.location_type,
      location_id:this.location_id,
      area_id:this.area_id
     }
   }; 
    this.scheduleService.getScheduleResourcesUsers(param).subscribe((res: any[])=>{
      this.resources = res;
      this.calendarOptions.resources = this.resources;  
      this.ngAfterViewInit(); 
    }); 
   }
   //Resources Area
   scheduleResourcesArea(){     
     let param = {params:{
       super_users_id:this.users_id,
       business_id:this.business_id,
       location_type:this.location_type,
       location_id:this.location_id,
       area_id:this.area_id
      }
    };
    
    this.scheduleService.getScheduleResourcesArea(param).subscribe((res: any[])=>{
      this.resources = res;   
      this.calendarOptions.resources = this.resources;  
      this.ngAfterViewInit(); 
    }); 
   }

  /* 
  onDateClick(res:any ) {  //{ dateStr: string; }


   //res.dayElffd.style.backgroundColor = 'red';

    //console.log(res);
   // alert('Clicked on: ' + res.dateStr);
   // alert('Coordinates: ' + res.jsEvent.pageX + ',' + res.jsEvent.pageY);
   // alert('Current view: ' + res.view.type);
    //res.resource._resource.ui.backgroundColor = "#656666";

     let date =res.dateStr;
     this.id='';
    
     var datePipe = new DatePipe('en-US');
     this.start_date = datePipe.transform(date, 'yyyy-MM-dd');
     this.title = "Schedule on " + this.start_date;

     this.btnSaveText='Save';
 
    //  this.show(this.id,this.start_date);
  }*/

//https://github.com/fullcalendar/fullcalendar-example-projects/blob/master/angular/src/app/app.component.ts
// https://angular.io/guide/observables-in-angular
//https://www.itsolutionstuff.com/post/angular-8-bootstrap-modal-popup-exampleexample.html
//https://therichpost.com/add-bootstrap-4-to-angular-6/
//https://www.positronx.io/angular-service-tutorial-with-example/
//https://fullcalendar.io/docs/timegrid-view

  ngOnInit(): void {
    var t= setInterval(()=>{
      if(typeof this.resources=='undefined'){
      
     }
    else{
      clearInterval(t);
       this.calendarOptions.resources = this.resources;
       this.calendarOptions.resourceOrder = 'order';
       this.setvalidRange();   
    }
  },100);


     
     this.scheduleService.getScheduleArea({params:{super_users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{
      this.dropdownListMemLoc = [];
      
      for(let i=0;i<res.length;i++){
        this.dropdownListMemLoc.push( { item_id: res[i].id, item_text:  res[i].area_name });
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
    
    });

    this.scheduleService.getScheduleLocationArea({params:{super_users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{
      this.location_area =  res;
    });
}

style_view:boolean=false;
ngAfterViewInit(){

  var t= setInterval(()=>{
    if(typeof this.resources=='undefined'){
    
   }
  else{
    clearInterval(t);
    this.loadSchedule();
   
    // Your CSS as text
    var styles =`
    .fc td, .fc th {
      vertical-align: top;
      padding: 0;
      height: 100px;
    }
    a{
      color:#3d1cba;
    }
    .fc-direction-ltr .fc-timeline-event.fc-event-end,
    .fc-direction-ltr .fc-timeline-more-link{
      top:30px;
     }
    `;

    
    let styleSheet = document.createElement("style");
    styleSheet.innerText = styles;
    document.head.appendChild(styleSheet);


    let arrTD = document.querySelectorAll('td.fc-timeline-slot');

    let arrTR= document.querySelectorAll('td.fc-timeline-lane.fc-resource');
    let arrInject= document.querySelectorAll('td.fc-timeline-lane.fc-resource>div.fc-timeline-lane-frame');


    let k=-1;
    arrTR.forEach(eachTR => {
        let i=1;
        let str = '';
        k++;

        let data_resource_id= eachTR.getAttribute('data-resource-id');
 
        arrTD.forEach(eachTD => {   
            let eachWidth = 0; 
            eachWidth = arrTD[0].clientWidth;
            let  k=eachWidth*(i-1);
            i=i+1;
            let data_date= eachTD.getAttribute('data-date');

            let data_resource_id= eachTR.getAttribute('data-resource-id'); 

            let id = data_date+''+data_resource_id;

            str = str + '<span id="'+id+'" data-date="'+data_date+'"   data-resource-id="'+data_resource_id+'" class="plus_icon" style="position:absolute;top: 0px; left: '+k+'px !important;z-index:4;width:20px;height:20px;border:1px  solid #ddd;text-align:center;">+</span>';          
         
      });
        arrInject[k].innerHTML='<div style="position:absolute;">'+str+'</div>';

    });

    
    let elementList = this.elRef.nativeElement.querySelectorAll('span.plus_icon');
    for(let i=0;i<elementList.length;i++){   
     elementList[i].addEventListener('click', this.plusClick.bind(this));
    }
    
  }
},100)

}


plusClick(property:any){
  let str:any;

  let id= property.srcElement.id;
  let id1= property.srcElement.id+'_1';
  let id2= property.srcElement.id+'_2';
  let id3= property.srcElement.id+'_3';
  let el=document.getElementById(id) as HTMLElement;
  // el.style.position='left:0px';
  if(parseInt(this.cal_day_range)==6){
    el.style.width = '145px';
  }
  else{
    el.style.width = '100px';
  }
   el.style.height = '100px';

   el.style.backgroundColor = '#3d1cba';
 // el.style.position = 'absolute';

  let clip = 'clipboard';
  if(this.id_copied>0){
    clip = 'droplet';
 }else if(this.id_copied<0){
     clip = 'clipboard';
 }
  str =`<span>
          <span id="`+id1+`" style="border:1px solid #FFF;color:#FFF;">
             <i class="bi bi-pencil-square"  style="padding:5px;"></i>
          </span>
          <span id="`+id2+`" style="border:1px solid #FFF;color:#FFF;">
             <i class="bi bi-plus-square" style="padding:5px;"></i>
          </span>  
          <span id="`+id3+`" style="border:1px solid #FFF;color:#FFF;">
            <i class="bi bi-`+clip+`" style="padding:5px;"></i>
          </span>
        </span>`;

      el.innerHTML = str;
      el.addEventListener('mouseleave',(_e)=>{
        el.innerHTML =  '+';
        el.style.position = 'absolute';
        el.style.width = 'auto';
        el.style.height = 'auto';
        el.style.backgroundColor = '#FFF';
       // this.ngAfterViewInit();
     });

     let el1=document.getElementById(id1) as HTMLElement;     
     el1.addEventListener('click',(_e)=>{
       this.scheduleEdit(property,_e);
     });

     let el2=document.getElementById(id2) as HTMLElement;     
     el2.addEventListener('click',(_e)=>{
       this.show(property);
     });

     let el3=document.getElementById(id3) as HTMLElement;     
     el3.addEventListener('click',(_e)=>{
      if(this.id_copied<0){
         this.copySchedule(property,_e);
      }else if(this.id_copied>0){
         this.pasteSchedule(property,_e);
      }
     });
      
}

toggleUserDetails(i:any){
  this.showeUserDetails[i] = !this.showeUserDetails[i];
  for(let j=0;j<this.dataset.length;j++){
    if(j==i){
      continue;
    }
    this.showeUserDetails[j] = false;
  }
}

//https://fullcalendar.io/docs/timeline-view
setvalidRange(){ 
  let calendarApi = this.calendarComponent?.getApi();

  if(parseInt(this.cal_day_range)==0){
    calendarApi?.changeView('resourceTimelineDay');
  }
  else if(parseInt(this.cal_day_range)==6){

    calendarApi?.changeView('resourceTimelineSevenDay');
    this.calendarOptions.slotDuration ={ days: 1 };
  }
  else if(parseInt(this.cal_day_range)==13){
    calendarApi?.changeView('resourceTimelineMonth');
    this.calendarOptions.slotDuration ={ days: 1 };
  }
 else if(parseInt(this.cal_day_range)==27){
    calendarApi?.changeView('resourceTimelineMonth');
    
  }
 else if(parseInt(this.cal_day_range)==29){
    calendarApi?.changeView('resourceTimelineMonth');
  }

  let start:any;
  var datePipe = new DatePipe('en-US');
  //start
  if(typeof this.schedule_start_date=='undefined' ){
    let date: Date = new Date();
    date.setDate(date.getDate());
    start = datePipe.transform(date, 'yyyy-MM-dd');
    const [year, month, day] =  start.split('-');
    const obj = { year: parseInt(year), month: parseInt(month), day:parseInt(day.split(' ')[0].trim()) };
    this.schedule_start_date = obj;
  }
  else{
    start = this.schedule_start_date.year+'-'+this.schedule_start_date.month+'-'+this.schedule_start_date.day;
  }

  var lastday = new Date(this.schedule_start_date.year, this.schedule_start_date.month , 0).getDate();

  
  this.cal_start_date = datePipe.transform(start, 'yyyy-MM-dd');
  this.cal_end_date = datePipe.transform(start, 'yyyy-MM-dd');  
  if(parseInt(this.cal_day_range)==29){
    start = this.schedule_start_date.year+'-'+this.schedule_start_date.month+'-'+lastday;
    this.cal_end_date = datePipe.transform(start, 'yyyy-MM-dd'); 
  }


 
  let date: Date = new Date(this.cal_end_date);
  date.setDate(date.getDate() + parseInt(this.cal_day_range));
  this.cal_end_date = datePipe.transform(date, 'yyyy-MM-dd');

  let days = 1+ parseInt(this.cal_day_range);
  this.calendarOptions.duration = { days: days};




  if(parseInt(this.cal_day_range)==6){

    let date: Date = new Date(start);
    date.setDate(date.getDate() + parseInt(this.cal_day_range)+1);
    let end :any = datePipe.transform(date, 'yyyy-MM-dd'); 
    this.calendarOptions.validRange={
      start: this.cal_start_date,
      end: end
    };
  }else{
    this.calendarOptions.validRange={
      start: this.cal_start_date,
      end: this.cal_end_date
    };
  }  

 
  this.calendarOptions.eventConstraint={
    start: this.cal_start_date,
    end: this.cal_end_date
  };

  
  this.ngAfterViewInit();
 
  this.loadSchedule();
 
}

swithchResources(){
  if(this.resource_type=='resource_by_member'){
    this.scheduleResourcesUsers();
  }
  else if(this.resource_type=='resource_by_area'){
    this.scheduleResourcesArea();
  }
}

onLocationSelect(event: any){
  let arrVal = event.target.value.split('-');  
  this.location_type=arrVal[1];
  if(arrVal[1]=='parent'){
    this.location_id=arrVal[0];
    this.area_id='';
  }
  else if(arrVal[1]=='child'){
    this.location_id= '';
    this.area_id=arrVal[0];
  }
  else{
    this.location_id='';  
    this.area_id='';
    this.location_type='';
  }

  if(this.resource_type=='resource_by_member'){
    this.scheduleResourcesUsers();
  }
  else if(this.resource_type=='resource_by_area'){
    this.scheduleResourcesArea();
  }
}

/*
*loadSchedule
*/

loadSchedule(){
  let param = {params:{
    super_users_id:this.users_id,
    business_id:this.business_id,
    resource_type:this.resource_type,
    location_type:this.location_type,
    location_id:this.location_id,
    area_id:this.area_id,
    start_date:this.cal_start_date,
    end_date:this.cal_end_date
   }};
   
   this.SpinnerService.show();   
   this.scheduleService.getScheduleLoad(param)
      .subscribe((res:[any]) => {
        this.calendarOptions.events = res;
        this.SpinnerService.hide();   
      })

   this. getUsers();   
   this.countUnpublishedSchedule();

  }

  countUnpublishedSchedule(){
    let param = {params:{
      super_users_id:this.users_id,
      business_id:this.business_id,
      resource_type:this.resource_type,
      location_type:this.location_type,
      location_id:this.location_id,
      area_id:this.area_id,
      start_date:this.cal_start_date,
      end_date:this.cal_end_date
     }};
     
     this.SpinnerService.show();   
     this.scheduleService.countUnpublishedSchedule(param)
        .subscribe((res:[any]) => {
          console.log(res);
          this.total_unpublished= res;
          this.SpinnerService.hide();   
        })
    }

    
    publishedSchedule(){
   
      Swal.fire({
        title: '<strong>Select Option</strong>',
        html:
        `<input type="checkbox" [(ngModel)]="email_option"  id="email_option"   value="email">Email <br>
        <input type="checkbox"  [(ngModel)]="sms_option"  id="sms_option" value="sms">SMS
        `,
        showCancelButton: true,
        confirmButtonText: 'Ok',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

             let pub_by:any[]=[];
             if($("#email_option").is(':checked')){
                  pub_by.push('email');
             }
             if($("#sms_option").is(':checked')){
                pub_by.push('sms');
             }

            let param = {params:{
              super_users_id:this.users_id,
              business_id:this.business_id,
              resource_type:this.resource_type,
              location_type:this.location_type,
              location_id:this.location_id,
              area_id:this.area_id,
              start_date:this.cal_start_date,
              end_date:this.cal_end_date,
              pub_by:pub_by
            }};
            
            this.SpinnerService.show();   
            this.scheduleService.publishedSchedule(param)
                .subscribe((res:[any]) => {
                  this.toastr.success(res[0].msg);
                  this.loadSchedule();
                  this.SpinnerService.hide();   
                })
        }
      })
    }


  addIcon(){
      var selectedDays = document.querySelectorAll('.fc-day-future > .fc-daygrid-day-frame > .fc-daygrid-day-events');
      console.log(selectedDays);
      for(var i = 0; i < selectedDays.length; ++i){
        if(selectedDays[i].querySelectorAll(".fc-daygrid-event-harness").length === 0 &&  selectedDays[i].querySelectorAll(".fa-plus").length === 0){
          selectedDays[i].innerHTML = selectedDays[i].innerHTML + '<div class="text-center"><i class="calendar-icon fas fa-plus"></i></span></div>';
        }
      }

      document.querySelectorAll('.fc-button').forEach(function(el){
        el.addEventListener('click', () => {
          
        });
      }); 
  }
  
   /* 
    handleDateSelect(selectInfo: DateSelectArg) {
    // const title = prompt('Please enter a new title for your event');
      const calendarApi = selectInfo.view.calendar;

      calendarApi.unselect(); // clear date selection
    }

    handleEventClick(clickInfo: EventClickArg) {
     // if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
     //   clickInfo.event.remove();
     // }

    let date =clickInfo.event.start;
    this.id=clickInfo.event.id;
    console.log(this.id);
   
    var datePipe = new DatePipe('en-US');
    this.start_date = datePipe.transform(date, 'yyyy-MM-dd');
    this.title = "Schedule on " + this.start_date;

    this.btnSaveText='Update';

     //this.show(this.id,this.start_date);
    }

    handleEvents(events: EventApi[]) {
      this.currentEvents = events;
    }
    */


     //Bootstrap Modal Open event
  //show(id_str:any,start_date_str:any) {//
  show(property:any) {  
     
      let data_date = property.srcElement.getAttribute('data-date');

      var datePipe = new DatePipe('en-US');
      this.start_date = datePipe.transform(data_date, 'yyyy-MM-dd');
      this.title = "Schedule on " + this.start_date;

      let time1 = datePipe.transform(data_date, 'HH:00'); 
      let time2 = datePipe.transform(data_date, 'HH:30'); 
      this.start = time1;
      this.finish = time2;
      this.meal_break = 15;
      this.rest_break = 15;

      let data_resource_id = property.srcElement.getAttribute('data-resource-id');
  
     this.showModal = true;
     

    this.users_list=[];
    this.area_list=[]; 
    this.start_list = [];
    this.finish_list = [];
    this.meal_break_list = [];
    this.rest_break_list = [];
    this.area_selected = '';
    this.assign_by_users_id_selected = '';
    this.assign_to_users_id_selected =  '';
    this.company_id_selected =  '';
    this.finish_selected =  '';
    this.meal_break_selected =  '';
    this.notes_selected =  '';
    this.rest_break_selected =  '';
    this.start_selected =  '';
    this.start_date_selected =  '';

    this.peopleService.getPeople({params:{business_id:this.business_id}}).subscribe((res: any[])=>{
      this.dropdownListScheWho = [];
      for(let i=0;i<res.length;i++){
        this.dropdownListScheWho.push( { item_id: res[i].id, item_text:  res[i].first_name+' '+res[i].last_name });
       }
       
      this.selectedItemsScheWho = [];
      this.dropdownSettingsScheWho= {
      singleSelection: true,
      idField: 'item_id',
      textField: 'item_text',
     // selectAllText: 'Select All',
     // unSelectAllText: 'UnSelect All',
      itemsShowLimit: 1,
      allowSearchFilter: true 
      }

       //make selected
       this.resources.forEach((element: any) => {
        if(element.id==data_resource_id && this.resource_type =='resource_by_member'){
          this.selectedItemsScheWho =[{item_id:element.id,item_text:element.title}];
        }
        else if(element.id==data_resource_id && this.resource_type =='resource_by_area'){
          this.selectedItemsScheLoc =[{item_id:element.id,item_text:element.title}];
        }
      });


    }); 
   
    
    this.scheduleService.getScheduleArea({params:{super_users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{
        this.dropdownListScheLoc = [];
        
        for(let i=0;i<res.length;i++){
            //console.log(res[i].id);    
          this.dropdownListScheLoc.push( { item_id: res[i].id, item_text:  res[i].area_name });
          }       
          
        this.selectedItemsScheLoc = [];
        this.dropdownSettingsScheLoc= {
        singleSelection: true,
        idField: 'item_id',
        textField: 'item_text',
        // selectAllText: 'Select All',
        // unSelectAllText: 'UnSelect All',
        itemsShowLimit: 1,
        allowSearchFilter: true 
        }

        //make selected
        this.resources.forEach((element: any) => {
          if(element.id==data_resource_id && this.resource_type =='resource_by_member'){
            this.selectedItemsScheWho =[{item_id:element.id,item_text:element.title}];
          }
          else if(element.id==data_resource_id && this.resource_type =='resource_by_area'){
            this.selectedItemsScheLoc =[{item_id:element.id,item_text:element.title}];
          }
        });

      }); 


    this.start_list = this.schudleData.start_list;    
    this.finish_list =this.schudleData.finish_list;
    this.meal_break_list =this.schudleData.meal_break_list;
    this.rest_break_list = this.schudleData.rest_break_list;

    this.quantities().clear();

    setTimeout(()=>{  
    this.scheduleService.getScheduleDetail({params:{id:this.id}}).subscribe((response: any) => {
      if(this.id>0){
        this.selectedItemsScheLoc = [{item_id:response[0].area_id,item_text:response[0].area}];
        this.selectedItemsScheWho = [{item_id:response[0].worker_users_id,item_text:response[0].worker}];
        this.finish_selected = response[0]['finish'];
        this.meal_break_selected = response[0]['meal_break'];
        this.notes_selected = response[0]['notes'];
        this.rest_break_selected = response[0]['rest_break'];
        this.start_selected = response[0]['start'];
        this.start_date_selected = response[0]['start_date'];
        
        this.more_detail_arr_selected = response[0]['more_detail'];

        for(let i=0;i<this.more_detail_arr_selected.length;i++){
          this.quantities().push(this.newDynamicQuantity(this.more_detail_arr_selected[i]));
        } 

        this.start =  this.start_selected;
        this.finish = this.finish_selected;

     }
     else{
      this.start_selected = '09:00';
      this.finish_selected = '17:00';    
      this.start =  this.start_selected;
      this.finish = this.finish_selected;
     }

    }, 
    (error: any) => {
      console.log(error)
    }); 
  }, 500);

}

scheduleEdit(property:any,_e:Event){
  let calendarApi = this.calendarComponent?.getApi();
  let data_date = property.srcElement.getAttribute('data-date');
  let data_resource_id = property.srcElement.getAttribute('data-resource-id');
  //var element = document.elementFromPoint(property.x, property.y);
  let str:any = JSON.stringify(this.calendarOptions.events);
  let events = JSON.parse(str);

  events.forEach((element: any)  => {
    if(element.name==property.srcElement.id){
        this.id=element.id;  
        this.show(property);
      }
  });
}



copySchedule(property:any,_e:Event){
    this.id_copied= -1;
    this.data_resource_id_copied = property.srcElement.getAttribute('data-resource-id');
    let str:any = JSON.stringify(this.calendarOptions.events);
    let events = JSON.parse(str);

    events.forEach((element: any)  => {
      if(element.name==property.srcElement.id){
          this.id_copied=element.id;  
          this.toastr.success("Copied has been completed successfully");
        }
    });
}

pasteSchedule(property:any,_e:Event){


  this.data_date_copied = property.srcElement.getAttribute('data-date');
  let datePipe = new DatePipe('en-US');
  let date: Date = new Date(this.data_date_copied);
  let dropped_date  = datePipe.transform(date, 'yyyy-MM-dd');

 ///////////////////////////////////////////
 this.scheduleService.getScheduleDetail({params:{id:this.id_copied}}).subscribe((response: any) => {

  let param = {params:{
        super_users_id:response[0]['super_users_id'],
        business_id:response[0]['business_id'],
        worker_users_id:property.srcElement.getAttribute('data-resource-id'),
        start:response[0]['start'],
        finish:response[0]['finish'],
        start_date:dropped_date,
      }
    }; 


    this.scheduleService.checkOverlapping(param).subscribe((res: any[])=>{
           let overlapping = res[0]['status']; 
          
           if(overlapping=='success' && this.resource_type=='resource_by_member'){
            Swal.fire('Overlapping',res[0]['msg'],'error');
           } 
           if( this.resource_type=='resource_by_area'){
              overlapping = 'fail';
           }
  
          if(overlapping=='fail'){
          ////////////////////////////////////////
            
                let data_str = JSON.stringify( {
                    id: this.id_copied,
                    old_resource_id:this.data_resource_id_copied,   
                    new_resource_id:property.srcElement.getAttribute('data-resource-id'),
                    dropped_date:dropped_date,
                    resource_type:this.resource_type,
                });

                this.scheduleService.copyPasteSchedule(data_str).subscribe( (response: any) => {
                          let resobj = JSON.parse(response);
                            if(resobj.status=='success'){
                              this.id_copied = -1;
                              this.toastr.success("Pasted has been completed successfully");
                              this.loadSchedule();
                            }
                          }, 
                        (error: any) => {
                          console.log(error)
                        }); 
  
            ////////////////////////////////////////

            }
        });

      });
 
}



  //Bootstrap Modal Close event
hide(){
  this.showModal = false;
  this.id = -1;
}

  
saveSchedule(){

  let param = {params:{
      super_users_id:this.users_id,
      business_id:this.business_id,
      worker_users_id:this.selectedItemsScheWho[0].item_id,
      start:this.start,
      finish:this.finish,
      start_date:this.start_date,
    }
  }; 
  this.scheduleService.checkOverlapping(param).subscribe((res: any[])=>{
         let overlapping = res[0]['status']; 

         if( this.id>0){
          overlapping = 'fail';
         }
        
         if(overlapping=='success'){
          Swal.fire('Overlapping',res[0]['msg'],'error');
         } 

        if(overlapping=='fail'){
            this.more_detail = this.productForm.get("quantities")?.value;
            let data_str = JSON.stringify( {
                  company_id:1,
                  super_users_id:this.users_id,
                  worker_users_id:this.selectedItemsScheWho[0].item_id,
                  area_id:this.selectedItemsScheLoc[0].item_id,
                  start:this.start,
                  finish:this.finish,
                  meal_break:this.meal_break,
                  rest_break:this.rest_break,
                  notes:this.notes,
                  start_date:this.start_date,
                  id:this.id,
                  more_detail:this.more_detail,
              });
        
            this.scheduleService.saveSchedule(data_str).subscribe( (response: any) => {
                        let resobj = JSON.parse(response);
                          if(resobj.status=='success'){
                            this.id='';
                            this.hide();
                            this.loadSchedule();
                          }
                        }, 
                      (error: any) => {
                        console.log(error)
                      });
               }
    } );

}



deleteSchedule(id:any){
  if(confirm("Are you sure to delete this item?")){
  let data_str = JSON.stringify( {
    id:id
   });
  this.scheduleService.deleteSchedule(data_str).subscribe( (response: any) => {
    console.log(response);
    let resobj = JSON.parse(response);
       console.log(resobj.status);
       if(resobj.status=='success'){
         this.hide();
         this.loadSchedule();
       }
    }, 
   (error: any) => {
    console.log(error)
  });
  }
}

memberAreaBasis(_type:any,_duration:any){

}

//////////////////////////////
quantities() : FormArray {  
  return this.productForm.get("quantities") as FormArray  
}  
   
newQuantity(): FormGroup {  
  return this.fb.group({  
    brkd_type: '',  
    brkd_duration: '',  
    brkd_start: '',  
    brkd_finish: '',  
  })  
}  

newDynamicQuantity(obj:any): FormGroup {  
  return this.fb.group({  
    brkd_type: obj.type,  
    brkd_duration: obj.duration,  
    brkd_start: obj.start,  
    brkd_finish: obj.finish,  
  })  
} 
   
addQuantity() {  
  this.quantities().push(this.newQuantity());  
}  
   
removeQuantity(i:number) {  
  this.quantities().removeAt(i);  
}  

setBrkdFinish(i:number){
  let brkd_duration1 =  this.quantities().at(i).get('brkd_duration')?.value;
  let brkd_start1 =  this.quantities().at(i).get('brkd_start')?.value;
  //let brkd_finish1 = this.quantities().at(i).get('brkd_start')?.value;

  const [hr,min] = brkd_start1.split(':');
  let total_min = hr*60+parseInt(min)+parseInt(brkd_duration1);

  let hr1 =  Math.floor(total_min/60);
  let min1 = total_min%60;
  let str = '';
  if(hr1==24){
     hr1= 0;
  }
  if(hr1>=0&&hr1<9){
     str = "0"+hr1
  }
  else{
    str = hr1.toString();
  }
 
  
  if(min1>=0&&min1<9){
    str = str+":0"+min1;
  }
  else{
    str = str+":"+min1;
  }


  this.quantities().at(i).patchValue({brkd_finish:str});
 

}
///////////////////////////////


////////////////Member////////////

showMember(){
  this.showMemberModal = true;
  this.addQuantity2();
}

hideMember(){
  this.showMemberModal = false;
  this.id = -1;
  }

  
  onItemSelect(item: any) {
    console.log(item);
  }
  onSelectAll(items: any) {
    console.log(items);
  }


  quantities2() : FormArray {  
    return this.productForm2.get("quantities2") as FormArray  
  }  
     
  newQuantity2(): FormGroup {  
    return this.fb.group({  
      name: '',  
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

///////////////////////////////////
inviteUserslist(){
  let param = {params:{
    super_users_id:this.users_id,
    business_id:this.business_id,
    worker_users_id:this.selectedItemsScheWho[0].item_id,
    start:this.start,
    finish:this.finish,
    start_date:this.start_date,
  }
}; 
  this.scheduleService.inviteUserslist(param).subscribe((res: any[])=>{
    this.invite_users_list = res;

    console.log(this.invite_users_list);
    
  }); 
 }
//send offers
sendOffers(id:any){
  this.inviteUserslist();
  this.showModal = false; 
  this.showSendOfferModal = true;
  this.id_invite = id;

}
hideSendOffer(){
  this.showSendOfferModal = false;
  this.users_id_list = [];
  this.id=-1;
}

onCheckboxChange(event: any) {
  if (event.target.checked) {
    this.users_id_list.push(event.target.value);
  } else {
    const index =this.users_id_list.findIndex((element) => element===event.target.value);
    this.users_id_list.splice(index, 1);
  }

  console.log(this.users_id_list);
}
 

inviteSchedule(id:any){
  let param = {params:{
    id:id,
    super_users_id:this.users_id,
    business_id:this.business_id,
    //resource_type:this.resource_type,
    //location_type:this.location_type,
    //location_id:this.location_id,
    //area_id:this.area_id,
    //start_date:this.cal_start_date,
    //end_date:this.cal_end_date,
    users_id_list:JSON.stringify(this.users_id_list)
  }};

  console.log(param);
  
  this.SpinnerService.show();   
  this.scheduleService.inviteSchedule(param)
      .subscribe((res:[any]) => {
        this.toastr.success(res[0].msg);
        this.showSendOfferModal = false;
        this.users_id_list = [];
        this.id=-1;
        this.loadSchedule();
        this.SpinnerService.hide();   
      })
}

//publish
publish(id:any){

  this.showModal = false;

  Swal.fire({
    title: '<strong>Select Option</strong>',
    html:
    `<input type="checkbox" [(ngModel)]="email_option"  id="email_option"   value="email">Email <br>
    <input type="checkbox"  [(ngModel)]="sms_option"  id="sms_option" value="sms">SMS
    `,
    showCancelButton: true,
    confirmButtonText: 'Ok',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
           

         let pub_by:any[]=[];
         if($("#email_option").is(':checked')){
              pub_by.push('email');
         }
         if($("#sms_option").is(':checked')){
            pub_by.push('sms');
         }

        let param = {params:{
          id:id,
          super_users_id:this.users_id,
          business_id:this.business_id,
          resource_type:this.resource_type,
          location_type:this.location_type,
          location_id:this.location_id,
          area_id:this.area_id,
          start_date:this.cal_start_date,
          end_date:this.cal_end_date,
          pub_by:pub_by
        }};
        
        this.SpinnerService.show();   
        this.scheduleService.publishedScheduleId(param)
            .subscribe((res:[any]) => {
              this.toastr.success(res[0].msg);
              this.loadSchedule();
              this.SpinnerService.hide();   
            })
    }
  })
}

repeatSevenDays(id:any){
  this.showModal = false;

  let data_str = JSON.stringify( {
    id: id,
    resource_type:this.resource_type,
});

this.scheduleService.repeatSevenDaysSchedule(data_str).subscribe( (response: any) => {
          let resobj = JSON.parse(response);
            if(resobj.status=='success'){
              this.id=-1;
              this.toastr.success("Repetition  has been completed successfully");
              this.loadSchedule();
            }
          }, 
        (error: any) => {
          console.log(error)
        }); 

}

viewDetails(id:any){
}

}
