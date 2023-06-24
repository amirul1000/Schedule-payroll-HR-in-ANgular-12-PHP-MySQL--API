import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class BusinessService  {
  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }

  countBusiness(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=count_business',data);
       //.subscribe(res =>{return res});
   }

  saveBusiness(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=save_business',data);
   }



  getBusiness(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=business',data);//
       //.subscribe(res =>{return res});
   }

   getAllBusiness(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_all_business',data);
   }

   deleteBusiness(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=delete_business',data);
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
