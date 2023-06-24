import { Component, OnInit } from '@angular/core';

import { FormGroup, FormControl, FormArray, FormBuilder } from '@angular/forms';  

import {NewsService} from '../news.service';

import { PeopleService } from '../people.service';


import { IDropdownSettings } from 'ng-multiselect-dropdown'

import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from "ngx-spinner";  
import { Router, ActivatedRoute, ParamMap } from '@angular/router';


@Component({
  selector: 'app-news',
  templateUrl: './news.component.html',
  styleUrls: ['./news.component.css']
})
export class NewsComponent implements OnInit {
  file_picture:any="";
  user :any ={};
  first_name:any;
  last_name:any;
  email:any;
  users_id : any;
  user_type : any;
  business:any;
  business_name:any;
  business_id:any;
  selected_users_id:any;

  dropdownList: any[]=[];
  selectedItems: any[]=[];
  dropdownSettings:IDropdownSettings ={};

  showNewsModal:boolean=false;
  news_id:any=0;
  news_list:any;
  leave_apply:any;

  news_content:any;
  file_news:any;
  id:any;

  defaultImg = 'assets/images/circle-line-point-area-clip-art-png-favpng-CvaYhEcU64kWWSUQa3gVdNS78.jpg';


  constructor(private newsService:NewsService,private SpinnerService:NgxSpinnerService,
    private peopleService:PeopleService,
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

   //Load news
   this.loadNews();
   this.getLeaveByBusiness();

   this.loadDropdownData();

  }

 loadNews(){
  this.newsService.getNews({params:{users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{
    this.news_list = res;
  }); 

 }
  
loadDropdownData(){
  this.newsService.getShareWith({params:{users_id:this.users_id,business_id:this.business_id}}).subscribe((res: any[])=>{

  this.dropdownList = [];
  for(let i=0;i<res.length;i++){
    this.dropdownList.push( { item_id: res[i], item_text: res[i] });
   }
  this.selectedItems = [];
  this.dropdownSettings= {
  singleSelection: false,
  idField: 'item_id',
  textField: 'item_text',
 // selectAllText: 'Select All',
 // unSelectAllText: 'UnSelect All',
  itemsShowLimit: 10,
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
  saveNews(){

    let keywords:any[] = [];
    this.selectedItems.forEach(item=>{
      keywords.push(item.item_id);
   
    });

    const formData = new FormData();
    formData.append('file_news', this.myForm.get('fileSource')?.value);

    formData.append('creator_users_id', this.users_id);
    formData.append('business_id', this.business_id);
    formData.append('contents', this.news_content);
    formData.append('keywords', keywords.toString());
    formData.append('user_type',this.user_type);
    formData.append('id', this.id);

  /* let  data_str = JSON.stringify( {
      creator_users_id:this.users_id,
      business_id:this.business_id,
      contents:this.news_content,
      keywords: typeof this.selectedItems[0]!=='undefined'?this.selectedItems:'',
   });*/
   this.newsService.saveNews(formData).subscribe((response: any) => {
    this.SpinnerService.show(); 
    let resobj = JSON.parse(response); 
        if(resobj[0].status=='success'){  
            this.loadNews();
            this.getLeaveByBusiness();
            this.toastr.success(resobj[0].msg);
            this.SpinnerService.hide();   
            this.hideNews();
        }else{
          this.toastr.error(resobj[0].msg);     
          this.SpinnerService.hide();                
        }
    }, 
    (error: any) => {
    console.log(error);
    });

  }

  editNews(id:any){



  }

  deleteNews(id:any){



  }
   
  hideNews(){
    this.showNewsModal = !this.showNewsModal;
  }

  showNews(){
    this.showNewsModal = !this.showNewsModal;
  }


  
 ////Admin
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
 getLeaveByBusiness(){
  this.peopleService.getLeaveByBusiness({params:{
    business_id:this.business_id}}).subscribe((response: any) => {
    this.SpinnerService.show();  
         this.leave_apply =response; 
         console.log(this.leave_apply);
            /*if(this.leave_apply[0].status=='success'){  
                this.toastr.success(this.leave_apply[0].msg);
              
            }else{
                      
            } */
            this.SpinnerService.hide();   
           
    }, 
    (error: any) => {
    console.log(error);
    }); 
 }


 accept(id:any){
  if(confirm("Are you sure to accept this Leave Apply?")){
    this.peopleService.acceptLeaveApply({params:{
      id:id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
      let resobj = response; 
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

 reject(id:any){
  if(confirm("Are you sure to reject this Leave Apply?")){
    this.peopleService.rejectLeaveApply({params:{
      id:id}}).subscribe((response: any) => {
      this.SpinnerService.show();  
      let resobj = response; 
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
