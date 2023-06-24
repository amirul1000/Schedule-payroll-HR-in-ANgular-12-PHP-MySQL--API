import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';


export interface Users{
  id:number,
  first_name:string,
  last_name:string
}


@Injectable({
  providedIn: 'root'
})
export class ScheduleService {
  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }

  getUsers(): any{
   return this.http.get('http://localhost/pm/index.php/server/serve?cmd=users');//
      //.subscribe(res =>{return res});
  }


  getArea(): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=area');//
       //.subscribe(res =>{return res});
   }

   getProjectArea(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=project_area',data);//
       //.subscribe(res =>{return res});
   }



   getScheduleArea(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=schedule_area',data);//
       //.subscribe(res =>{return res});
   }


   getLocationArea(): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=location_area');//
       //.subscribe(res =>{return res});
   }

   
  inviteUserslist(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=invite_users_list',data);//
       //.subscribe(res =>{return res});
   }

   userslist(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=users_list',data);//
       //.subscribe(res =>{return res});
   }


   getScheduleLocationArea(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=schedule_location_area',data);//
       //.subscribe(res =>{return res});
   }



  getScheduleLoad(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=load_schedule',data);
  }

  getScheduleDetail(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=load_schedule_detail',data);
  }


  saveSchedule( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_schedule';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  getScheduleUsersPayroll(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=schedule_users_payroll',data);
  }


  getScheduleResourcesUsers(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=schedule_resources_users',data);
  }

  getScheduleResourcesArea(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=schedule_resources_area',data);
  }


  dargDropSchedule( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=drag_drop_schedule';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  copyPasteSchedule( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=copy_paste_schedule';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  repeatSevenDaysSchedule( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=repeat_seven_days_schedule';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }


  checkOverlapping(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=check_overlapping',data);
  }


  countUnpublishedSchedule(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=count_unpublished_schedule',data);
  }

  publishedSchedule(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=published_schedule',data);
  }

  publishedScheduleId(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=published_schedule_id',data);
  }

  inviteSchedule(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=invite_schedule',data);
  }
  
    // Create
   /* createSchedule(data: any): Observable<any> {
      let API_URL = `${this.apiUrl}?cmd=save_schedule`;
      return this.http.post(API_URL, data)
        .pipe(
          catchError(this.error)
        )
    }*/
   
    // Update
   /* updateSchedule(id: any, data: any): Observable<any> {
      let API_URL = `${this.apiUrl}/update-task/${id}`;
      return this.http.put(API_URL, data, { headers: this.headers }).pipe(
        catchError(this.error)
      )
    }*/
    // Delete
    deleteSchedule( data: any): Observable<any> {
      let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_schedule';
      return this.http.post(API_URL,  data, {responseType: 'text'}).pipe(
        catchError(this.error)
      );    
    }
    // Handle Errors 
    error(error: HttpErrorResponse) {
      let errorMessage = '';
      if (error.error instanceof ErrorEvent) {
        errorMessage = error.error.message;
      } else {
        errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
      }
      console.log(errorMessage);
      return throwError(errorMessage);
    }

}
