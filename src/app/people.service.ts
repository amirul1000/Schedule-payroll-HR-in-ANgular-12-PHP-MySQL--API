import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class PeopleService {
  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }

  getPeople(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=users',data);//
       //.subscribe(res =>{return res});
   }

   getUsersAccessLevel(): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=access_level');//
       //.subscribe(res =>{return res});
   }

   saveSingleUser( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_user';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }
  
  saveMultiUsers( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_multi_users';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  uploadCSV( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=upload_people_csv';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  archiveTeamMember(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=archive_team_member',data);
  }

  getMemberdetails(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=member_details',data);
  }

  ///Payroll
  savePayroll(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_payroll';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  deletePayroll(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_payroll';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }


  getPayroll(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_payroll',data);//
       //.subscribe(res =>{return res});
   }

   getUsersPayroll(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_users_payroll',data);//
       //.subscribe(res =>{return res});
   }


   getUserSchedule(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_user_schedule',data);//
       //.subscribe(res =>{return res});
   }




   //training
   saveTraining(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_training';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  getTrainingdetails(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=training_details',data);
  }


  deleteTraining(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_training';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }
  //////////

  //leave
  saveLeave(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_leave';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  getLeavedetails(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=leave_details',data);
  }

 deleteLeave(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_leave';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }
  //////////

  //unavailability
  saveUnavailability(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_unavailability';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  getUnavailabilitydetails(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=unavailability_details',data);
  }

 deleteUnavailability(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_unavailability';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }
  //////////
   
  getProfile(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_profile',data);//
       //.subscribe(res =>{return res});
   }

  updateProfile(data: any): Observable<any> {    
       let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=update_profile';
       return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
         catchError(this.error)
       )
   }

   uploadPicture( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=upload_picture';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  downloadLeaveCSVFormat( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=download_leave_csv';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  uploadLeaveCSV( data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=upload_leave_csv';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }


  //Leave apply
  saveLeaveApply(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_leave_apply';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  
 deleteLeaveApply(data: any): Observable<any> {
  let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_leave_apply';
  return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
    catchError(this.error)
  )
}

//admin
getLeaveByBusiness(data: any): any{
  return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_leave_by_business',data);
}

acceptLeaveApply(data: any): any{
  return this.http.get('http://localhost/pm/index.php/server/serve?cmd=accept_leave_apply',data);
}

rejectLeaveApply(data: any): any{
  return this.http.get('http://localhost/pm/index.php/server/serve?cmd=reject_leave_apply',data);
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
