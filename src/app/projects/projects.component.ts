import { Component, OnInit } from '@angular/core';

import { FormGroup, FormControl, FormArray, FormBuilder } from '@angular/forms';  

import { ProjectsService } from '../projects.service';
import { ScheduleService } from '../schedule.service';



import { IDropdownSettings } from 'ng-multiselect-dropdown'
import {NgbDateStruct, NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { HttpClient } from '@angular/common/http';


import { NgxSpinnerService } from "ngx-spinner";  
import { ToastrService } from 'ngx-toastr';


@Component({
  selector: 'app-projects',
  templateUrl: './projects.component.html',
  styleUrls: ['./projects.component.css']
})
export class ProjectsComponent implements OnInit {
  file_picture:any="";
  user :any ={};
  first_name:any;
  last_name:any;
  email:any;
  users_id : any;
  business:any;
  business_name:any;
  business_id:any;

  searchText:any; 
  projects:any;
  showProjectModal:boolean=false;
  project_title:any;
  project_description:any;
  file_project:any;
  assign_to_users_id :any;
  location_id :any;
  notes :any;
  priority :any;
  project_status :any;

  dropdownListScheWho: any[]=[];
  selectedItemsScheWho: any[]=[];
  dropdownSettingsScheWho: IDropdownSettings ={};

  dropdownListMemLoc: any[]=[];
  selectedItemsMemLoc: any[]=[];
  dropdownSettingsMemLoc: IDropdownSettings ={};

  dropdownListPriority: any[]=[];
  selectedItemsPriority: any[]=[];
  dropdownSettingsPriority: IDropdownSettings ={};

  dropdownListStatus: any[]=[];
  selectedItemsStatus: any[]=[];
  dropdownSettingsStatus: IDropdownSettings ={};

  id:any=-1;
  due_date!: NgbDateStruct;
  date!: {year: number, month: number};


  constructor(private projectsService:ProjectsService,private scheduleService:ScheduleService,private httpClient: HttpClient,
    private modalService: NgbModal, private fb:FormBuilder,private SpinnerService:NgxSpinnerService,
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



    }

  ngOnInit(): void {
    this.projectsService.getProjects().subscribe((res: any[])=>{
      this.projects = res;    
    });

    let param = {params:{
      business_id:this.business_id,
  }}; 
    this.scheduleService.userslist(param).subscribe((res: any[])=>{
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


    let param1 = {params:{
      users_id    : this.users_id,
      business_id :this.business_id,
     }
   };

    this.scheduleService.getProjectArea(param1).subscribe((res: any[])=>{

      let res1 = res[0].area;

      this.dropdownListMemLoc = [];
      for(let i=0;i<res1.length;i++){
        this.dropdownListMemLoc.push( { item_id: res1[i].id, item_text:  res1[i].area_name });
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


    this.projectsService.getProjectPriority().subscribe((res: any[])=>{
      this.dropdownListPriority = [];
      for(let i=0;i<res.length;i++){
        this.dropdownListPriority.push( { item_id: res[i], item_text:  res[i] });
       }
      this.selectedItemsPriority = [];
      this.dropdownSettingsPriority= {
      singleSelection: true,
      idField: 'item_id',
      textField: 'item_text',
     // selectAllText: 'Select All',
     // unSelectAllText: 'UnSelect All',
      itemsShowLimit: 1,
      allowSearchFilter: true 
      }
    
    });


    this.projectsService.getProjectStatus().subscribe((res: any[])=>{
      this.dropdownListStatus = [];
      for(let i=0;i<res.length;i++){
        this.dropdownListStatus.push( { item_id: res[i], item_text:  res[i] });
       }
      this.selectedItemsStatus= [];
      this.dropdownSettingsStatus= {
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

  onItemSelect(item: any) {
    console.log(item);
  }
  onSelectAll(items: any) {
    console.log(items);
  }

  addProjectModal(){
    this.showProjectModal = true;
  }

  hideProject(){
    this.showProjectModal = false;
    this.id = '-1';
  }
  
  myForm = new FormGroup({
    name: new FormControl('', []),
    file: new FormControl('', []),
    fileSource: new FormControl('', [])
  });
  
  onFileChange(event:any) {
      const file = event.target.files[0];
      this.myForm.patchValue({
        fileSource: file
      });
  } 
  
  editProject(id:any){
     this.addProjectModal();
     this.id = id; 
     this.projectsService.getProject({params:{
      id:id,
      users_id:this.users_id,
      business_id:this.business_id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
          let resobj =response; 
              if(resobj[0].status=='success'){  
                  this.toastr.success(resobj[0].msg);


                  this.assign_to_users_id = resobj[0]['project'][0].assign_to_users_id;
                  this.location_id = resobj[0]['project'][0].location_id; 
                  this.project_title = resobj[0]['project'][0].project_title; 
                  this.project_description = resobj[0]['project'][0].project_description; 
                  this.due_date  = resobj[0]['project'][0].due_date; 
                  this.notes = resobj[0]['project'][0].notes; 
                  this.priority  = resobj[0]['project'][0].priority; 
                  this.project_status = resobj[0]['project'][0].project_status; 
                 
                  
              }else{
               // this.toastr.error(resobj[0].msg);      
                this.id ='-1';            
              }
              this.SpinnerService.hide();   
      }, 
      (error: any) => {
      console.log(error);
      }); 


  }
  
  deleteProject(id:any){
    if(confirm("Are you sure to delete this Project?")){
      let  data_str = JSON.stringify( {
        id:id
        }); 
        this.projectsService.deleteProject(data_str).subscribe((response: any) => {
       this.SpinnerService.show(); 
       let resobj = JSON.parse(response); 
           if(resobj[0].status=='success'){  
               this.toastr.success(resobj[0].msg);
               this.SpinnerService.hide();  
               this.id = -1; 
               this.projectsService.getProjects().subscribe((res: any[])=>{
                this.projects = res;    
              });
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

  saveProject(id:any){
    if(typeof this.selectedItemsMemLoc[0]=='undefined' ||  this.selectedItemsMemLoc[0]==''){
      this.toastr.error('Location is a required field');      
      return;
     }
     
    const formData = new FormData();
    formData.append('file_project', this.myForm.get('fileSource')?.value);

    formData.append('assign_to_users_id', this.selectedItemsScheWho[0].item_id);
    formData.append('users_name', this.selectedItemsScheWho[0].item_text);
    formData.append('project_title',this.project_title);
    formData.append('project_description',this.project_description);

    if(typeof this.due_date!='undefined'){
      formData.append('due_date',this.due_date.year+'-'+this.due_date.month +'-'+this.due_date.day);
     }


    formData.append('priority', this.selectedItemsPriority[0].item_id);
    formData.append('project_status', this.selectedItemsStatus[0].item_id);

    formData.append('location_id', this.selectedItemsMemLoc[0].item_id);
    formData.append('main_location', this.selectedItemsMemLoc[0].item_text);
    formData.append('super_users_id', this.users_id);
    formData.append('business_id', this.business_id);
    formData.append('id', this.id);

  
    this.projectsService.saveProject(formData).subscribe( (response: any) => {
              this.SpinnerService.show();  
               let resobj = JSON.parse( response); 
                  if(resobj[0].status=='success'){                       
                      this.id = -1;
                      this.toastr.success(resobj[0].msg);
                      this.hideProject();  
                      this.projectsService.getProjects().subscribe((res: any[])=>{
                        this.projects = res;    
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
