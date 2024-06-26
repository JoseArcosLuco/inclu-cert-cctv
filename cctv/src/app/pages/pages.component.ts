import { Component, OnInit } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { HeaderComponent } from "../share/header/header.component";
import { MainSidebarComponent } from "../share/main-sidebar/main-sidebar.component";
import { FooterComponent } from '../share/footer/footer.component';
import { DashboardComponent } from './dashboard/dashboard.component';


@Component({
    selector: 'app-pages',
    standalone: true,
    templateUrl: './pages.component.html',
    styleUrl: './pages.component.css',
    imports: [ RouterOutlet, HeaderComponent, MainSidebarComponent, FooterComponent,DashboardComponent]
})
export class PagesComponent  {
  

}
