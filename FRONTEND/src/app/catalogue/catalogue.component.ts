import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Produit } from '../produit/produit';
import { CatalogueService } from './catalogue.service';
import { CommonModule } from '@angular/common';
import { ProduitComponent } from '../produit/produit.component';
import { MoteurDeRechercheComponent } from '../moteur-de-recherche/moteur-de-recherche.component';

@Component({
  selector: 'app-catalogue',
  standalone: true,
  imports: [CommonModule, ProduitComponent, MoteurDeRechercheComponent],
  templateUrl: './catalogue.component.html',
  styleUrls: ['./catalogue.component.css']
})
export class CatalogueComponent implements OnInit {
  catalogue$?: Observable<Produit[]>; 

  constructor(private catalogueService: CatalogueService) {}

  ngOnInit(): void {
    this.catalogue$ = this.catalogueService.getCatalogue();
  }
}
