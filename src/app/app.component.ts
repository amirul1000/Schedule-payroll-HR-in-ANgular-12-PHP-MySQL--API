import { Component } from '@angular/core';

import { Router, ActivatedRoute, ParamMap} from '@angular/router';



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'pm';

  file_picture:any="";
  user :any ={};
  first_name:any;
  last_name:any;
  phone_no:any;
  email:any;
  user_type:any;
  showBusinessModal:boolean=false;

  headerVisible:boolean=false;

  business:any;
  business_name:any;
  business_id:any;
  selected_business_id:any='';


  constructor(private route: ActivatedRoute,
    private router: Router){

      if(localStorage.getItem('user')){
        this.headerVisible  = true;

        let user_json:any = localStorage.getItem('user');
        this.user =  JSON.parse(user_json); 
        this.file_picture = this.user.file_picture;
        this.first_name  = this.user.first_name; 
        this.last_name  = this.user.last_name; 
        this.phone_no = this.user.phone_no; 
        this.email = this.user.email; 
        this.user_type = this.user.user_type;
       }  

       if(localStorage.getItem('business')){
          let businesss_json:any = localStorage.getItem('business');
          this.business =  JSON.parse(businesss_json); 
          this.business_name = this.business.business_name;
          this.selected_business_id = this.business.id;
       }
    }

    ngOnInit(): void {
      
    } 
    
    switchBusinessPopup(){
       this.showBusinessModal =  true;
    }

    hideBusiness(){
      this.showBusinessModal = false;
    }

    exPand(){
      if($('#navbarNav').css('display') == 'none' || $('#navbarNav').css('display') == ''  )
      {
        $("#navbarNav").css("display","block");
      }
      else{
        $("#navbarNav").css("display","none");
      }
    }

    
}
