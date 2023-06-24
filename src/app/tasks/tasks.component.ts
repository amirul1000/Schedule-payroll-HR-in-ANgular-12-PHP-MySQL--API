import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { FormGroup, FormControl, FormArray, FormBuilder } from '@angular/forms'  

import { CalendarOptions , DateSelectArg, EventClickArg, EventApi } from '@fullcalendar/angular';


import {NgbModal, NgbDate,NgbDateStruct, NgbCalendar,NgbInputDatepickerConfig} from '@ng-bootstrap/ng-bootstrap';

import { ScheduleService } from '../schedule.service';
import { DatePipe } from '@angular/common';

import { IDropdownSettings } from 'ng-multiselect-dropdown';

import {TaskDataComponent} from './task.data';

//https://www.npmjs.com/package/ng-multiselect-dropdown

@Component({
  selector: 'app-tasks',
  templateUrl: './tasks.component.html',
  styleUrls: ['./tasks.component.css'],
  providers: [NgbInputDatepickerConfig]  // add config to the component providers
})
export class TasksComponent implements OnInit {

  showModal: boolean = false;
  showNotes: any[] = [];
  name = 'Angular';  
  productForm: FormGroup; 
  polling: any;
  task:any;
  subtask:any;
  hr: any;
  min:any;
  notes:any;

  showindividualModal: boolean = false;
  showListModal: boolean = false;


  assignto:any;

  repeat_date!: NgbDateStruct;
  date!: {year: number, month: number};
  repeat_type:any;

  individual_date!: NgbDateStruct;

  dropdownList!: any[];
  selectedItems!: any[];
  dropdownSettings: IDropdownSettings ={};


  dateShow:boolean=false;
  weeklyShow:boolean=false;
  monthlyShow:boolean=false;


  dropdownListScheWho: any[]=[];
  selectedItemsScheWho: any[]=[];
  dropdownSettingsScheWho: IDropdownSettings ={};



  dropdownListScheLoc: any[]=[];
  selectedItemsScheLoc: any[]=[];
  dropdownSettingsScheLoc: IDropdownSettings ={};

  searchText:any; 
  task_list_title : any;


  constructor(private httpClient: HttpClient,
    private modalService: NgbModal,
    private fb:FormBuilder,private calendar: NgbCalendar,private config: NgbInputDatepickerConfig,
    private scheduleService : ScheduleService,
    private taskDataComponent:TaskDataComponent) { 
         
      this.productForm = this.fb.group({  
        name: '',  
        quantities: this.fb.array([]) ,  
      });  
    /*
      // customize default values of datepickers used by this component tree
    config.minDate = {year: 1900, month: 1, day: 1};
    config.maxDate = {year: 2099, month: 12, day: 31};

    // days that don't belong to current month are not visible
    config.outsideDays = 'hidden';

    // weekends are disabled
   // config.markDisabled = (date: NgbDate) => calendar.getWeekday(date) >= 6;

    // setting datepicker popup to close only on click outside
    config.autoClose = 'outside';

    // setting datepicker popup to open above the input
    config.placement = ['top-start', 'top-end'];*/

    this.scheduleService.getArea().subscribe((res: any[])=>{
      this.dropdownListScheLoc = [
       
     ];
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


    }); 
    


    }

  ngOnInit(): void {
     
    this.dropdownList = this.taskDataComponent.dropdownList;

    this.selectedItems = [];
    this.dropdownSettings= {
      singleSelection: false,
      idField: 'item_id',
      textField: 'item_text',
      selectAllText: 'Select All',
      unSelectAllText: 'UnSelect All',
      itemsShowLimit: 31,
      allowSearchFilter: true
    };


  }

  onItemSelect(item: any) {
    console.log(item);
  }
  onSelectAll(items: any) {
    console.log(items);
  }

  selectToday() {
    this.repeat_date = this.calendar.getToday();

    this.individual_date =  this.calendar.getToday();

    console.log(this.repeat_date);

  }

  repeatTypeChange(){
    this.dateShow=false;
    this.weeklyShow=false;
    this.monthlyShow=false;

    if(this.repeat_type=='Do not repeat'){
      this.dateShow=   true;  
    }else if(this.repeat_type=='Daily'){

    }else if(this.repeat_type=='Weekly'){
      this.weeklyShow= true;
    }else if(this.repeat_type=='Monthly'){
      this.monthlyShow= true;
    }

  } 


  showModalTasksForaWholeArea(){
    this.showModal = true; 
    this.showNotes[0] = false;
    this.addQuantity();
    
  }

   //Bootstrap Modal Close event
   hide() {
    this.showModal = false;
    }

  toggleNotes(i:any){
    this.showNotes[i] = !this.showNotes[i];
  }


  //individual 

  showModalIndividual(who:string){
    this.showindividualModal = true;

    this.scheduleService.getUsers().subscribe((res: any[])=>{
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
    }); 
    

  }

  hideIndividual() {
    this.showindividualModal = false;
    }

    
   //Task List
    showTaskListInModal(modal_type: any){
      this.showListModal = true;
      if(modal_type=='my_task'){
           this.task_list_title = 'My Tasks';
      }
      else if (modal_type=='assigned'){
        this.task_list_title = 'Assigned Tasks';
      }
    }
    hideList(){
      this.showListModal = false;
    }   

//////////////////////////////
quantities() : FormArray {  
  return this.productForm.get("quantities") as FormArray  
}  
   
newQuantity(): FormGroup {  
  return this.fb.group({  
    subtask: '',  
    hr: '',  
    min: '',  
    notes: '',  
  })  
}  

newDynamicQuantity(obj:any): FormGroup {  
  return this.fb.group({  
    subtask: obj.subtask,  
    hr: obj.hr,  
    min: obj.min,  
    notes: obj.notes,  
  })  
} 
   
addQuantity() {  
  this.quantities().push(this.newQuantity());  
}  
   
removeQuantity(i:number) {  
  this.quantities().removeAt(i);  
}  
///////////////////////////////

}
