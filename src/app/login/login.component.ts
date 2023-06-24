import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';


import { LoginRegisterProfileService } from '../login-register-profile.service';


import { ToastrService } from 'ngx-toastr';
import { NgxSpinnerService } from "ngx-spinner";  

import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import {
  SocialAuthService,
  GoogleLoginProvider,
  SocialUser,
} from 'angularx-social-login';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  email:any;
  password:any;
  error:any;

  loginForm!: FormGroup;
  socialUser!: SocialUser;
  isLoggedin?: boolean =false;


  showRegisterModal:boolean = false;
  reg_email:any;
  reg_password:any;

  constructor(private loginRegisterProfileService:LoginRegisterProfileService,
    private formBuilder: FormBuilder,
    private socialAuthService: SocialAuthService,
    private route: ActivatedRoute,
    private router: Router,
    private toastr:ToastrService) {

      if(localStorage.getItem('user')){
        this.isLoggedin  = true;
       }  

       
      let cmd = this.route.snapshot.params['cmd']; 
      if(cmd=='logout'){
        this.logOut();
      }

   }

  ngOnInit(): void {

    this.loginForm = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required],
    });
    this.socialAuthService.authState.subscribe((user) => {
      this.socialUser = user;
      this.isLoggedin = user != null;      
      if(this.isLoggedin){
        this.router.navigate(['dashboard'], { })
        .then(() => {
          window.location.reload();
        });
        }
    });

  }

  loginWithGoogle(): void {
    this.socialAuthService.signIn(GoogleLoginProvider.PROVIDER_ID).then(
      (user) => {

        this.socialUser = user;
        this.isLoggedin = user != null;  
        console.log(user.email);
        this.loginRegisterProfileService.checkExistEmail({params:{email:user.email}}).subscribe((response: any) => {
          let status = response[0]['status'];
          let userobj = response[0]['user'];
          //console.log(status);
          //console.log(userobj);
          if(status=='success'){
              if(this.isLoggedin){ 
                  localStorage.setItem('user',JSON.stringify(userobj));
                  this.router.navigate(['/dashboard', { }])
                  .then(() => {
                    window.location.reload();
                  });  
                }
              }else if(status=='fail'){
                  //add new user
              this.email = user.email;    
              this.password = Math.random();
              let new_user_json  =  {params:{'email' : this.email.toString(),
                  'password' : this.password,
                  'first_name': user.firstName,
                  'last_name' : user.lastName,
                  'file_picture': user.photoUrl,
                  'user_type' : 'Location Manager'}};

                  this.loginRegisterProfileService.register(new_user_json).subscribe((response: any) => {
                    let status = response[0]['status'];
                    let userobj = response[0]['user'];
                    //console.log(userobj);
                    if(status=='success'){
                            localStorage.setItem('user',JSON.stringify(userobj));
                            this.router.navigate(['/dashboard', { }])
                            .then(() => {
                              window.location.reload();
                            });  
                          
                        }else if(status=='fail'){
                        } 
                  }, 
                  (error: any) => {
                    console.log(error)
                  }); 
              
              } 
        }, 
        (error: any) => {
          console.log(error)
        }); 



         
      });
  }
  logOut(): void {
    localStorage.removeItem('user');
    this.socialAuthService.signOut();
    this.router.navigate(['login'], { })
    .then(() => {
      window.location.reload();
    });
  }

  logIn(){
    this.loginRegisterProfileService.login({params:{email:this.email,password:this.password}}).subscribe((response: any) => {
      
        let status = response[0]['status'];
        if(status=='success'){
              let user = response[0]['user'];
              localStorage.setItem('user',JSON.stringify(user));

              this.error = "Login Successfully.";
              this.router.navigate(['/dashboard', { }])
              .then(() => {
                window.location.reload();
              });

        }else if(status=='fail'){
            this.error = "Login fail.Please check your email and pasword.";
        } 
    }, 
    (error: any) => {
      console.log(error)
    }); 

  }

  hideRegister(){
    this.showRegisterModal = false;  
  }

  showRegister(){
    this.showRegisterModal = true;  
  }

  register(){

    this.loginRegisterProfileService.register({params:{email:this.reg_email,password:this.reg_password,user_type:'System Administrator'}}).subscribe((response: any) => {
      
      let status = response[0]['status'];
      if(status=='success'){
        this.toastr.success(response[0].msg);                    

      }else if(status=='fail'){
        this.toastr.error(response[0].msg);  
      } 
  }, 
  (error: any) => {
    console.log(error)
  }); 




  }

}
