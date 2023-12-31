import { Injectable } from '@angular/core'; // at top

@Injectable({
  providedIn: 'root' // just before your class
})


export class ScheduleDataComponent {

  public start_list : any[] = [
    {"key":"00:00","value":"12:00 AM"},
    {"key":"00:15","value":"12:15 AM"},
    {"key":"00:30","value":"12:30 AM"},
    {"key":"00:45","value":"12:45 AM"},    
    {"key":"01:00","value":"1:00 AM"},
    {"key":"01:15","value":"1:15 AM"},	
    {"key":"01:30","value":"1:30 AM"},	
    {"key":"01:45","value":"1:45 AM"},	
    {"key":"02:00","value":"2:00 AM"},
    {"key":"02:15","value":"2:15 AM"},	
    {"key":"02:30","value":"2:30 AM"},	
    {"key":"02:45","value":"2:45 AM"},	
    {"key":"03:00","value":"3:00 AM"},
    {"key":"03:15","value":"3:15 AM"},	
    {"key":"03:30","value":"3:30 AM"},	
    {"key":"03:45","value":"3:45 AM"},	
    {"key":"04:00","value":"4:00 AM"},
    {"key":"04:15","value":"4:15 AM"},	
    {"key":"04:30","value":"4:30 AM"},	
    {"key":"04:45","value":"4:45 AM"},	
    {"key":"05:00","value":"5:00 AM"},
    {"key":"05:15","value":"5:15 AM"},	
    {"key":"05:30","value":"5:30 AM"},	
    {"key":"05:45","value":"5:45 AM"},	
    {"key":"06:00","value":"6:00 AM"},
    {"key":"07:15","value":"7:15 AM"},	
    {"key":"07:30","value":"7:30 AM"},	
    {"key":"07:45","value":"7:45 AM"},	
    {"key":"08:00","value":"8:00 AM"},
    {"key":"08:15","value":"8:15 AM"},	
    {"key":"08:30","value":"8:30 AM"},	
    {"key":"08:45","value":"8:45 AM"},	
    {"key":"09:00","value":"9:00 AM"},
    {"key":"09:15","value":"9:15 AM"},	
    {"key":"09:30","value":"9:30 AM"},	
    {"key":"09:45","value":"9:45 AM"},	
    {"key":"10:00","value":"10:00 AM"},
    {"key":"10:15","value":"10:15 AM"},	
    {"key":"10:30","value":"10:30 AM"},	
    {"key":"10:45","value":"10:45 AM"},	
    {"key":"11:00","value":"11:00 AM"},
    {"key":"11:15","value":"11:15 AM"},	
    {"key":"11:30","value":"11:30 AM"},	
    {"key":"11:45","value":"11:45 AM"},	
    {"key":"12:00","value":"12:00 PM"},
    {"key":"12:15","value":"12:15 PM"},	
    {"key":"12:30","value":"12:30 PM"},	
    {"key":"12:45","value":"12:45 PM"},	
    {"key":"13:00","value":"1:00 PM"},
    {"key":"13:15","value":"1:15 PM"},	
    {"key":"13:30","value":"1:30 PM"},	
    {"key":"13:45","value":"1:45 PM"},	
    {"key":"14:00","value":"2:00 PM"},
    {"key":"14:15","value":"2:15 PM"},	
    {"key":"14:30","value":"2:30 PM"},	
    {"key":"14:45","value":"2:45 PM"},	
    {"key":"15:00","value":"3:00 PM"},
    {"key":"15:15","value":"3:15 PM"},	
    {"key":"15:30","value":"3:30 PM"},	
    {"key":"15:45","value":"3:45 PM"},	
    {"key":"16:00","value":"4:00 PM"},
    {"key":"16:15","value":"4:15 PM"},	
    {"key":"16:30","value":"4:30 PM"},	
    {"key":"16:45","value":"4:45 PM"},	
    {"key":"17:00","value":"5:00 PM"},
    {"key":"17:15","value":"5:15 PM"},	
    {"key":"17:30","value":"5:30 PM"},	
    {"key":"17:45","value":"5:45 PM"},	
    {"key":"18:00","value":"6:00 PM"},
    {"key":"18:15","value":"6:15 PM"},	
    {"key":"18:30","value":"6:30 PM"},	
    {"key":"18:45","value":"6:45 PM"},	
    {"key":"19:00","value":"7:00 PM"},
    {"key":"19:15","value":"7:15 PM"},	
    {"key":"19:30","value":"7:30 PM"},	
    {"key":"19:45","value":"7:45 PM"},	
    {"key":"20:00","value":"8:00 PM"},
    {"key":"20:15","value":"8:15 PM"},	
    {"key":"20:30","value":"8:30 PM"},	
    {"key":"20:45","value":"8:45 PM"},	
    {"key":"21:00","value":"9:00 PM"},
    {"key":"21:15","value":"9:15 PM"},	
    {"key":"21:30","value":"9:30 PM"},	
    {"key":"21:45","value":"9:45 PM"},	
    {"key":"22:00","value":"10:00 PM"},	
    {"key":"22:15","value":"10:15 PM"},	
    {"key":"22:30","value":"10:30 PM"},	
    {"key":"22:45","value":"10:45 PM"},	
    {"key":"23:00","value":"11:00 PM"},
    {"key":"23:15","value":"11:15 PM"},	
    {"key":"23:30","value":"11:30 PM"},	
    {"key":"23:45","value":"11:45 PM"},
  ];

    public finish_list  : any[] = [
      {"key":"00:00","value":"12:00 AM"},
      {"key":"00:15","value":"12:15 AM"},
      {"key":"00:30","value":"12:30 AM"},
      {"key":"00:45","value":"12:45 AM"},    
      {"key":"01:00","value":"1:00 AM"},
      {"key":"01:15","value":"1:15 AM"},	
      {"key":"01:30","value":"1:30 AM"},	
      {"key":"01:45","value":"1:45 AM"},	
      {"key":"02:00","value":"2:00 AM"},
      {"key":"02:15","value":"2:15 AM"},	
      {"key":"02:30","value":"2:30 AM"},	
      {"key":"02:45","value":"2:45 AM"},	
      {"key":"03:00","value":"3:00 AM"},
      {"key":"03:15","value":"3:15 AM"},	
      {"key":"03:30","value":"3:30 AM"},	
      {"key":"03:45","value":"3:45 AM"},	
      {"key":"04:00","value":"4:00 AM"},
      {"key":"04:15","value":"4:15 AM"},	
      {"key":"04:30","value":"4:30 AM"},	
      {"key":"04:45","value":"4:45 AM"},	
      {"key":"05:00","value":"5:00 AM"},
      {"key":"05:15","value":"5:15 AM"},	
      {"key":"05:30","value":"5:30 AM"},	
      {"key":"05:45","value":"5:45 AM"},	
      {"key":"06:00","value":"6:00 AM"},
      {"key":"07:15","value":"7:15 AM"},	
      {"key":"07:30","value":"7:30 AM"},	
      {"key":"07:45","value":"7:45 AM"},	
      {"key":"08:00","value":"8:00 AM"},
      {"key":"08:15","value":"8:15 AM"},	
      {"key":"08:30","value":"8:30 AM"},	
      {"key":"08:45","value":"8:45 AM"},	
      {"key":"09:00","value":"9:00 AM"},
      {"key":"09:15","value":"9:15 AM"},	
      {"key":"09:30","value":"9:30 AM"},	
      {"key":"09:45","value":"9:45 AM"},	
      {"key":"10:00","value":"10:00 AM"},
      {"key":"10:15","value":"10:15 AM"},	
      {"key":"10:30","value":"10:30 AM"},	
      {"key":"10:45","value":"10:45 AM"},	
      {"key":"11:00","value":"11:00 AM"},
      {"key":"11:15","value":"11:15 AM"},	
      {"key":"11:30","value":"11:30 AM"},	
      {"key":"11:45","value":"11:45 AM"},	
      {"key":"12:00","value":"12:00 PM"},
      {"key":"12:15","value":"12:15 PM"},	
      {"key":"12:30","value":"12:30 PM"},	
      {"key":"12:45","value":"12:45 PM"},	
      {"key":"13:00","value":"1:00 PM"},
      {"key":"13:15","value":"1:15 PM"},	
      {"key":"13:30","value":"1:30 PM"},	
      {"key":"13:45","value":"1:45 PM"},	
      {"key":"14:00","value":"2:00 PM"},
      {"key":"14:15","value":"2:15 PM"},	
      {"key":"14:30","value":"2:30 PM"},	
      {"key":"14:45","value":"2:45 PM"},	
      {"key":"15:00","value":"3:00 PM"},
      {"key":"15:15","value":"3:15 PM"},	
      {"key":"15:30","value":"3:30 PM"},	
      {"key":"15:45","value":"3:45 PM"},	
      {"key":"16:00","value":"4:00 PM"},
      {"key":"16:15","value":"4:15 PM"},	
      {"key":"16:30","value":"4:30 PM"},	
      {"key":"16:45","value":"4:45 PM"},	
      {"key":"17:00","value":"5:00 PM"},
      {"key":"17:15","value":"5:15 PM"},	
      {"key":"17:30","value":"5:30 PM"},	
      {"key":"17:45","value":"5:45 PM"},	
      {"key":"18:00","value":"6:00 PM"},
      {"key":"18:15","value":"6:15 PM"},	
      {"key":"18:30","value":"6:30 PM"},	
      {"key":"18:45","value":"6:45 PM"},	
      {"key":"19:00","value":"7:00 PM"},
      {"key":"19:15","value":"7:15 PM"},	
      {"key":"19:30","value":"7:30 PM"},	
      {"key":"19:45","value":"7:45 PM"},	
      {"key":"20:00","value":"8:00 PM"},
      {"key":"20:15","value":"8:15 PM"},	
      {"key":"20:30","value":"8:30 PM"},	
      {"key":"20:45","value":"8:45 PM"},	
      {"key":"21:00","value":"9:00 PM"},
      {"key":"21:15","value":"9:15 PM"},	
      {"key":"21:30","value":"9:30 PM"},	
      {"key":"21:45","value":"9:45 PM"},	
      {"key":"22:00","value":"10:00 PM"},	
      {"key":"22:15","value":"10:15 PM"},	
      {"key":"22:30","value":"10:30 PM"},	
      {"key":"22:45","value":"10:45 PM"},	
      {"key":"23:00","value":"11:00 PM"},
      {"key":"23:15","value":"11:15 PM"},	
      {"key":"23:30","value":"11:30 PM"},	
      {"key":"23:45","value":"11:45 PM"},
    ];


    public brkd_start_list  : any[] = [
      {"key":"00:00","value":"12:00 AM"},
      {"key":"00:15","value":"12:15 AM"},
      {"key":"00:30","value":"12:30 AM"},
      {"key":"00:45","value":"12:45 AM"},    
      {"key":"01:00","value":"1:00 AM"},
      {"key":"01:15","value":"1:15 AM"},	
      {"key":"01:30","value":"1:30 AM"},	
      {"key":"01:45","value":"1:45 AM"},	
      {"key":"02:00","value":"2:00 AM"},
      {"key":"02:15","value":"2:15 AM"},	
      {"key":"02:30","value":"2:30 AM"},	
      {"key":"02:45","value":"2:45 AM"},	
      {"key":"03:00","value":"3:00 AM"},
      {"key":"03:15","value":"3:15 AM"},	
      {"key":"03:30","value":"3:30 AM"},	
      {"key":"03:45","value":"3:45 AM"},	
      {"key":"04:00","value":"4:00 AM"},
      {"key":"04:15","value":"4:15 AM"},	
      {"key":"04:30","value":"4:30 AM"},	
      {"key":"04:45","value":"4:45 AM"},	
      {"key":"05:00","value":"5:00 AM"},
      {"key":"05:15","value":"5:15 AM"},	
      {"key":"05:30","value":"5:30 AM"},	
      {"key":"05:45","value":"5:45 AM"},	
      {"key":"06:00","value":"6:00 AM"},
      {"key":"07:15","value":"7:15 AM"},	
      {"key":"07:30","value":"7:30 AM"},	
      {"key":"07:45","value":"7:45 AM"},	
      {"key":"08:00","value":"8:00 AM"},
      {"key":"08:15","value":"8:15 AM"},	
      {"key":"08:30","value":"8:30 AM"},	
      {"key":"08:45","value":"8:45 AM"},	
      {"key":"09:00","value":"9:00 AM"},
      {"key":"09:15","value":"9:15 AM"},	
      {"key":"09:30","value":"9:30 AM"},	
      {"key":"09:45","value":"9:45 AM"},	
      {"key":"10:00","value":"10:00 AM"},
      {"key":"10:15","value":"10:15 AM"},	
      {"key":"10:30","value":"10:30 AM"},	
      {"key":"10:45","value":"10:45 AM"},	
      {"key":"11:00","value":"11:00 AM"},
      {"key":"11:15","value":"11:15 AM"},	
      {"key":"11:30","value":"11:30 AM"},	
      {"key":"11:45","value":"11:45 AM"},	
      {"key":"12:00","value":"12:00 PM"},
      {"key":"12:15","value":"12:15 PM"},	
      {"key":"12:30","value":"12:30 PM"},	
      {"key":"12:45","value":"12:45 PM"},	
      {"key":"13:00","value":"1:00 PM"},
      {"key":"13:15","value":"1:15 PM"},	
      {"key":"13:30","value":"1:30 PM"},	
      {"key":"13:45","value":"1:45 PM"},	
      {"key":"14:00","value":"2:00 PM"},
      {"key":"14:15","value":"2:15 PM"},	
      {"key":"14:30","value":"2:30 PM"},	
      {"key":"14:45","value":"2:45 PM"},	
      {"key":"15:00","value":"3:00 PM"},
      {"key":"15:15","value":"3:15 PM"},	
      {"key":"15:30","value":"3:30 PM"},	
      {"key":"15:45","value":"3:45 PM"},	
      {"key":"16:00","value":"4:00 PM"},
      {"key":"16:15","value":"4:15 PM"},	
      {"key":"16:30","value":"4:30 PM"},	
      {"key":"16:45","value":"4:45 PM"},	
      {"key":"17:00","value":"5:00 PM"},
      {"key":"17:15","value":"5:15 PM"},	
      {"key":"17:30","value":"5:30 PM"},	
      {"key":"17:45","value":"5:45 PM"},	
      {"key":"18:00","value":"6:00 PM"},
      {"key":"18:15","value":"6:15 PM"},	
      {"key":"18:30","value":"6:30 PM"},	
      {"key":"18:45","value":"6:45 PM"},	
      {"key":"19:00","value":"7:00 PM"},
      {"key":"19:15","value":"7:15 PM"},	
      {"key":"19:30","value":"7:30 PM"},	
      {"key":"19:45","value":"7:45 PM"},	
      {"key":"20:00","value":"8:00 PM"},
      {"key":"20:15","value":"8:15 PM"},	
      {"key":"20:30","value":"8:30 PM"},	
      {"key":"20:45","value":"8:45 PM"},	
      {"key":"21:00","value":"9:00 PM"},
      {"key":"21:15","value":"9:15 PM"},	
      {"key":"21:30","value":"9:30 PM"},	
      {"key":"21:45","value":"9:45 PM"},	
      {"key":"22:00","value":"10:00 PM"},	
      {"key":"22:15","value":"10:15 PM"},	
      {"key":"22:30","value":"10:30 PM"},	
      {"key":"22:45","value":"10:45 PM"},	
      {"key":"23:00","value":"11:00 PM"},
      {"key":"23:15","value":"11:15 PM"},	
      {"key":"23:30","value":"11:30 PM"},	
      {"key":"23:45","value":"11:45 PM"},
    ];


    public brkd_finish_list  : any[] = [
      {"key":"00:00","value":"12:00 AM"},
      {"key":"00:15","value":"12:15 AM"},
      {"key":"00:30","value":"12:30 AM"},
      {"key":"00:45","value":"12:45 AM"},    
      {"key":"01:00","value":"1:00 AM"},
      {"key":"01:15","value":"1:15 AM"},	
      {"key":"01:30","value":"1:30 AM"},	
      {"key":"01:45","value":"1:45 AM"},	
      {"key":"02:00","value":"2:00 AM"},
      {"key":"02:15","value":"2:15 AM"},	
      {"key":"02:30","value":"2:30 AM"},	
      {"key":"02:45","value":"2:45 AM"},	
      {"key":"03:00","value":"3:00 AM"},
      {"key":"03:15","value":"3:15 AM"},	
      {"key":"03:30","value":"3:30 AM"},	
      {"key":"03:45","value":"3:45 AM"},	
      {"key":"04:00","value":"4:00 AM"},
      {"key":"04:15","value":"4:15 AM"},	
      {"key":"04:30","value":"4:30 AM"},	
      {"key":"04:45","value":"4:45 AM"},	
      {"key":"05:00","value":"5:00 AM"},
      {"key":"05:15","value":"5:15 AM"},	
      {"key":"05:30","value":"5:30 AM"},	
      {"key":"05:45","value":"5:45 AM"},	
      {"key":"06:00","value":"6:00 AM"},
      {"key":"07:15","value":"7:15 AM"},	
      {"key":"07:30","value":"7:30 AM"},	
      {"key":"07:45","value":"7:45 AM"},	
      {"key":"08:00","value":"8:00 AM"},
      {"key":"08:15","value":"8:15 AM"},	
      {"key":"08:30","value":"8:30 AM"},	
      {"key":"08:45","value":"8:45 AM"},	
      {"key":"09:00","value":"9:00 AM"},
      {"key":"09:15","value":"9:15 AM"},	
      {"key":"09:30","value":"9:30 AM"},	
      {"key":"09:45","value":"9:45 AM"},	
      {"key":"10:00","value":"10:00 AM"},
      {"key":"10:15","value":"10:15 AM"},	
      {"key":"10:30","value":"10:30 AM"},	
      {"key":"10:45","value":"10:45 AM"},	
      {"key":"11:00","value":"11:00 AM"},
      {"key":"11:15","value":"11:15 AM"},	
      {"key":"11:30","value":"11:30 AM"},	
      {"key":"11:45","value":"11:45 AM"},	
      {"key":"12:00","value":"12:00 PM"},
      {"key":"12:15","value":"12:15 PM"},	
      {"key":"12:30","value":"12:30 PM"},	
      {"key":"12:45","value":"12:45 PM"},	
      {"key":"13:00","value":"1:00 PM"},
      {"key":"13:15","value":"1:15 PM"},	
      {"key":"13:30","value":"1:30 PM"},	
      {"key":"13:45","value":"1:45 PM"},	
      {"key":"14:00","value":"2:00 PM"},
      {"key":"14:15","value":"2:15 PM"},	
      {"key":"14:30","value":"2:30 PM"},	
      {"key":"14:45","value":"2:45 PM"},	
      {"key":"15:00","value":"3:00 PM"},
      {"key":"15:15","value":"3:15 PM"},	
      {"key":"15:30","value":"3:30 PM"},	
      {"key":"15:45","value":"3:45 PM"},	
      {"key":"16:00","value":"4:00 PM"},
      {"key":"16:15","value":"4:15 PM"},	
      {"key":"16:30","value":"4:30 PM"},	
      {"key":"16:45","value":"4:45 PM"},	
      {"key":"17:00","value":"5:00 PM"},
      {"key":"17:15","value":"5:15 PM"},	
      {"key":"17:30","value":"5:30 PM"},	
      {"key":"17:45","value":"5:45 PM"},	
      {"key":"18:00","value":"6:00 PM"},
      {"key":"18:15","value":"6:15 PM"},	
      {"key":"18:30","value":"6:30 PM"},	
      {"key":"18:45","value":"6:45 PM"},	
      {"key":"19:00","value":"7:00 PM"},
      {"key":"19:15","value":"7:15 PM"},	
      {"key":"19:30","value":"7:30 PM"},	
      {"key":"19:45","value":"7:45 PM"},	
      {"key":"20:00","value":"8:00 PM"},
      {"key":"20:15","value":"8:15 PM"},	
      {"key":"20:30","value":"8:30 PM"},	
      {"key":"20:45","value":"8:45 PM"},	
      {"key":"21:00","value":"9:00 PM"},
      {"key":"21:15","value":"9:15 PM"},	
      {"key":"21:30","value":"9:30 PM"},	
      {"key":"21:45","value":"9:45 PM"},	
      {"key":"22:00","value":"10:00 PM"},	
      {"key":"22:15","value":"10:15 PM"},	
      {"key":"22:30","value":"10:30 PM"},	
      {"key":"22:45","value":"10:45 PM"},	
      {"key":"23:00","value":"11:00 PM"},
      {"key":"23:15","value":"11:15 PM"},	
      {"key":"23:30","value":"11:30 PM"},	
      {"key":"23:45","value":"11:45 PM"},
    ];



    public meal_break_list  : any[] = [
    {"key":"15","value":"15"},
    {"key":"30","value":"30"},
    {"key":"45","value":"45"},
    {"key":"60","value":"60"},
    {"key":"75","value":"75"},
    {"key":"90","value":"90"},
    {"key":"105","value":"105"},
    {"key":"120","value":"120"},
    {"key":"135","value":"135"},
    ];

    public rest_break_list  : any[] = [
    {"key":"15","value":"15"},
    {"key":"30","value":"30"},
    {"key":"45","value":"45"},
    {"key":"60","value":"60"},
    {"key":"75","value":"75"},
    {"key":"90","value":"90"},
    {"key":"105","value":"105"},
    {"key":"120","value":"120"},
    {"key":"135","value":"135"},
    ];
}