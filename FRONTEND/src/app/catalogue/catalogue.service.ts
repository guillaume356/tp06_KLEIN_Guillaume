import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { map, switchMap, shareReplay } from 'rxjs/operators'; 
import { Produit } from '../produit/produit';
import { environment } from '../environments/environement';

@Injectable({
  providedIn: 'root',
})
export class CatalogueService {
  private searchCriteriaSubject = new BehaviorSubject<{ name: string; brand: string }>({ name: '', brand: '' });
  searchCriteria$ = this.searchCriteriaSubject.asObservable();
  private products$: Observable<Produit[]>;

  constructor(private http: HttpClient) {
    this.products$ = this.http.get<Produit[]>(`${environment.baseUrl}/products`).pipe(
      shareReplay(1) // Caches the response
    );
  }

  public setSearchCriteria(criteria: { name: string; brand: string }): void {
    this.searchCriteriaSubject.next(criteria);
  }

  public getCatalogue(): Observable<Produit[]> {
    return this.searchCriteria$.pipe(
      switchMap(criteria => 
        this.products$.pipe(
          map(products => 
            products.filter(product => 
              (!criteria.name || product.name.toLowerCase().includes(criteria.name.toLowerCase())) &&
              (!criteria.brand || product.brand.toLowerCase().includes(criteria.brand.toLowerCase()))
            )
          )
        )
      )
    );
  }
}
