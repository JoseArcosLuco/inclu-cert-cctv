import { Component } from '@angular/core';
import { PagesComponent } from '../pages.component';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [PagesComponent],
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css'
})
export class DashboardComponent {

}
