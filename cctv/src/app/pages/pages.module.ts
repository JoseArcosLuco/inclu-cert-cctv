import { Routes, RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ShareModule } from '../share/share.module';



@NgModule({
    imports: [
        CommonModule,
        RouterModule,
        ShareModule,
    ],
    declarations: [],
    
    exports: [],
})

export class PagesModule {
}