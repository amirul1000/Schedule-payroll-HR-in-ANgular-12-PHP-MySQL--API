import { NgModule } from '@angular/core';
import { BrowserModule} from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ScheduleComponent } from './schedule/schedule.component';

// import modules
import { HttpClientModule } from '@angular/common/http';
import { FullCalendarModule } from '@fullcalendar/angular'; 
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';

import {NgbInputDatepickerConfig, NgbModule} from '@ng-bootstrap/ng-bootstrap';

import { FormsModule,ReactiveFormsModule} from '@angular/forms';

import { ScheduleService } from './schedule.service';
import { LocationsService } from './locations.service';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { ProfileComponent } from './profile/profile.component';
import { LoginRegisterProfileService } from './login-register-profile.service';
import { TasksComponent } from './tasks/tasks.component';

import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';
import { CommonModule } from '@angular/common';

import { Ng2SearchPipeModule } from 'ng2-search-filter';



import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline'; // a plugin!



import {SocialLoginModule,SocialAuthServiceConfig,} from 'angularx-social-login';
import { GoogleLoginProvider } from 'angularx-social-login';
import { DashboardComponent } from './dashboard/dashboard.component';
import { LocationsComponent } from './locations/locations.component';
import { PeopleComponent } from './people/people.component';

//import { AgmCoreModule } from '@agm/core';

import { DragDropModule } from '@angular/cdk/drag-drop';
import { ProjectsComponent } from './projects/projects.component';

import { NgxSpinnerModule } from "ngx-spinner";  
import { ToastrModule } from 'ngx-toastr';
import { CompanyComponent } from './company/company.component';
import { BusinessComponent } from './business/business.component';
  
//import momentPlugin from '@fullcalendar/moment'

//import { ColorPickerModule } from '@iplab/ngx-color-picker';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { NewsComponent } from './news/news.component';
import { ShiftComponent } from './shift/shift.component';

FullCalendarModule.registerPlugins([ 
  interactionPlugin,
  dayGridPlugin,
  timeGridPlugin,
  listPlugin,
  resourceTimelinePlugin,  
]);

@NgModule({
  declarations: [
    AppComponent,
    ScheduleComponent,
    LoginComponent,
    RegisterComponent,
    ProfileComponent,
    TasksComponent,
    DashboardComponent,
    LocationsComponent,
    PeopleComponent,
    ProjectsComponent,
    CompanyComponent,
    BusinessComponent,
    NewsComponent,
    ShiftComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    FullCalendarModule,
    HttpClientModule,
    NgbModule,
    FormsModule,  
    ReactiveFormsModule,
    NgMultiSelectDropDownModule.forRoot(),
    CommonModule,    
    Ng2SearchPipeModule,
    SocialLoginModule,
    //ColorPickerModule,
    //AgmCoreModule.forRoot({
    //  apiKey: 'AIzaSyAvcDy5ZYc2ujCS6TTtI3RYX5QmuoV8Ffw'
    //}),
    DragDropModule,
    NgxSpinnerModule,
    ToastrModule.forRoot(),
    FontAwesomeModule,
  ],
  providers: [ScheduleService,LoginRegisterProfileService,NgbInputDatepickerConfig,LocationsService,
    {
      provide: 'SocialAuthServiceConfig',
      useValue: {
        autoLogin: false,
        providers: [{
                  id: GoogleLoginProvider.PROVIDER_ID,
                  provider: new GoogleLoginProvider('932082400928-ub3mj9da05tr9cvv3legmj4dnic1ejan.apps.googleusercontent.com'),//Google-Client-ID-Goes-Here  189684864895-gnudpgc82rnttg633bfsqpops9856k7p.apps.googleusercontent.com
                },],
               } as SocialAuthServiceConfig,
    },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
