import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ScheduleComponent } from './schedule/schedule.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { ProfileComponent } from './profile/profile.component';
import { TasksComponent } from './tasks/tasks.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { PeopleComponent } from './people/people.component';
import { LocationsComponent } from './locations/locations.component';
import { ProjectsComponent } from './projects/projects.component';
import { CompanyComponent } from './company/company.component';
import { NewsComponent } from './news/news.component';

const routes: Routes = [  
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'schedule', component: ScheduleComponent },
  { path: 'login', component: LoginComponent },
  { path: 'login/:cmd', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
  { path: 'profile', component: ProfileComponent },
  { path: 'people', component: PeopleComponent },
  { path: 'locations', component: LocationsComponent },
  { path: 'locations/:id/:cmd', component: LocationsComponent },
  { path: 'tasks', component: TasksComponent },
  { path: 'projects', component: ProjectsComponent },
  { path: 'dashboard', component: DashboardComponent },
  { path: 'company', component: CompanyComponent },
  { path: 'news', component: NewsComponent },
];


@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
