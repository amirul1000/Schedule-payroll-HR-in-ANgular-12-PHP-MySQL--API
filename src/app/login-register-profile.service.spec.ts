import { TestBed } from '@angular/core/testing';

import { LoginRegisterProfileService } from './login-register-profile.service';

describe('LoginRegisterProfileService', () => {
  let service: LoginRegisterProfileService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(LoginRegisterProfileService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
