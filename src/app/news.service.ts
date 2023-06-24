import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class NewsService {

  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }

  getShareWith(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_share_with',data);//
       //.subscribe(res =>{return res});
   }


   getNews(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=get_news',data);//
       //.subscribe(res =>{return res});
   }

  saveNews(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_news';
    return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
      catchError(this.error)
    )
  }

  deleteNews(data: any): Observable<any> {
    let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_news';
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
