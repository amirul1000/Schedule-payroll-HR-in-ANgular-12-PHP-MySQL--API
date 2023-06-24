import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class ProjectsService {

  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }


  getProjects(): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=projects');//
       //.subscribe(res =>{return res});
   }
 
   getProjectPriority(): any{
     return this.http.get('http://localhost/pm/index.php/server/serve?cmd=project_priority');//
        //.subscribe(res =>{return res});
    }
 
    getProjectStatus(): any{
     return this.http.get('http://localhost/pm/index.php/server/serve?cmd=project_status');//
        //.subscribe(res =>{return res});
    }

    getProject(data: any): any{
      return this.http.get('http://localhost/pm/index.php/server/serve?cmd=projects_details',data);//
         //.subscribe(res =>{return res});
     }

    saveProject( data: any): Observable<any> {
      let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=save_project';
      return this.http.post(API_URL, data, {responseType: 'text'}).pipe(
        catchError(this.error)
      )
    }

    deleteProject( data: any): Observable<any> {
      let API_URL = 'http://localhost/pm/index.php/server/serve?cmd=delete_project';
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
