import { Injectable } from '@angular/core'; // at top

@Injectable({
  providedIn: 'root' // just before your class
})


export class TaskDataComponent {


public dropdownList : any[] =  [
    { item_id: 1, item_text: '1st' },
    { item_id: 2, item_text: '2nd' },
    { item_id: 3, item_text: '3rd' },
    { item_id: 4, item_text: '4th' },
    { item_id: 5, item_text: '5th' },
    { item_id: 6, item_text: '6th' },
    { item_id: 7, item_text: '7th' },
    { item_id: 8, item_text: '8th' },
    { item_id: 9, item_text: '9th' },
    { item_id: 10, item_text: '10th' },
    { item_id: 11, item_text: '11th' },
    { item_id: 12, item_text: '12th' },
    { item_id: 13, item_text: '13th' },
    { item_id: 14, item_text: '14th' },
    { item_id: 15, item_text: '15th' },
    { item_id: 16, item_text: '16th' },
    { item_id: 17, item_text: '17th' },
    { item_id: 18, item_text: '18th' },
    { item_id: 19, item_text: '19th' },
    { item_id: 20, item_text: '20th' },
    { item_id: 21, item_text: '21th' },
    { item_id: 22, item_text: '22th' },
    { item_id: 23, item_text: '23th' },
    { item_id: 24, item_text: '24th' },
    { item_id: 25, item_text: '25th' },
    { item_id: 26, item_text: '26th' },
    { item_id: 27, item_text: '27th' },
    { item_id: 28, item_text: '28th' },
    { item_id: 29, item_text: '29th' },
    { item_id: 30, item_text: '30th' },
    { item_id: 31, item_text: '31st' },     
  ];
  
}
