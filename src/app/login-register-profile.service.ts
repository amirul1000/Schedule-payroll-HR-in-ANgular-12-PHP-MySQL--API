import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';

import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { Observable, of , throwError} from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LoginRegisterProfileService {

  apiUrl: string = 'http://localhost/pm/index.php/server/serve?';
  headers = new HttpHeaders().set('Content-Type', 'application/json');

  constructor(private http: HttpClient) { }

  login(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=login',data);
  }

  checkExistEmail(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=check_exist_email',data);
  }

  register(data: any): any{
    return this.http.get('http://localhost/pm/index.php/server/serve?cmd=register',data);
  }


}
