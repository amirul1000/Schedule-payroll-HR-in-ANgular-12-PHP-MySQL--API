import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CompanyService {
  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }

  countCompany(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=count_company',data);
       //.subscribe(res =>{return res});
   }

   saveCompany(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=save_company',data);
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
