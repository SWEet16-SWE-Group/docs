import React from 'react';
import { render, screen } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom';
import RestaurantCard from '../components/RestaurantCard';

const mockRestaurant = {
  id: 1,
  nome: 'Test Restaurant',
  cucina: 'Italiana',
  orario: '10:00 - 22:00',
  indirizzo: 'Via Roma 1, Milano',
};

describe('RestaurantCard', () => {
  it('renders restaurant details correctly', () => {
    render(
      <MemoryRouter>
        <RestaurantCard restaurant={mockRestaurant} />
      </MemoryRouter>
    );

    expect(screen.getByText('Test Restaurant')).toBeInTheDocument();
    expect(screen.getByText('Cucina : Italiana')).toBeInTheDocument();
    expect(screen.getByText('Orario di apertura : 10:00 - 22:00')).toBeInTheDocument();
    expect(screen.getByText('Indirizzo : Via Roma 1, Milano')).toBeInTheDocument();
  });

  it('renders a link to the restaurant page', () => {
    render(
      <MemoryRouter>
        <RestaurantCard restaurant={mockRestaurant} />
      </MemoryRouter>
    );

    const link = screen.getByText('Vai alla pagina del ristorante');
    expect(link).toBeInTheDocument();
    expect(link).toHaveAttribute('href', '/ristorante/1');
  });
});
