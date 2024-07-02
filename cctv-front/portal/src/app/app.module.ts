import { NgModule,CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { BrowserModule, provideClientHydration } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MainSidebarComponent } from './shared/main-sidebar/main-sidebar.component';
import { RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';


@NgModule({
  declarations: [
    AppComponent,
    MainSidebarComponent,
    HomeComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    RouterModule
  ],
  providers: [
    provideClientHydration()
  ],
  schemas: [ CUSTOM_ELEMENTS_SCHEMA],
  bootstrap: [AppComponent]
})
export class AppModule { }
