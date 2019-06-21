import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import 'rxjs/add/operator/map';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'front';
  private apiSearchUrl = 'http://localhost:8000/app.php/api/v1/transactions';

  data: any = {};

  constructor(private http : HttpClient) {
    this.getTransactions();
    this.getData();
  }

  getData() {
    return this.http.get(this.apiSearchUrl).map((res: Response) => res);
  }

  getTransactions() {
    return this.getData().subscribe(data => {
      console.log(data);
      this.data = data;
    })
  }
}
