import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LocationsService {
  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }

  countLocation(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=count_location',data);
       //.subscribe(res =>{return res});
   }

  saveLocation(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_location';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  deleteLocation(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_location';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  getLocations(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_all_locations',data);//
       //.subscribe(res =>{return res});
   }

   getLocation(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=location',data);//
       //.subscribe(res =>{return res});
   }


   /*
     Location
   */
   saveArea(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_area';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  deleteArea(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_area';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }


  getAllAreasOfBusiness(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_all_areas_of_business',data);//
       //.subscribe(res =>{return res});
   }


  getAreas(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_all_areas',data);//
       //.subscribe(res =>{return res});
   }

   
   getArea(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=area',data);//
       //.subscribe(res =>{return res});
   }

   saveShift(data: any): Observable<any> {
       let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_location_shift';
       return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
         catchError(this.error)
       )

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
