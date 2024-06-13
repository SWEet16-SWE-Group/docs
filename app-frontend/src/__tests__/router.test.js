import React from 'react';
import { render, screen, waitFor } from '@testing-library/react';
import { RouterProvider, createMemoryRouter } from 'react-router-dom';
import { useStateContext } from '../contexts/ContextProvider';
import router from '../router.jsx';

jest.mock('../contexts/ContextProvider', () => ({
  useStateContext: jest.fn(),
}));

describe('Router', () => {
  const renderWithRouter = (initialEntries = ['/']) => {
    const memoryRouter = createMemoryRouter(router.routes, { initialEntries });
    return render(<RouterProvider router={memoryRouter} />);
  };

  it('renders the login page when path is /login', () => {
    useStateContext.mockReturnValue({ token: null, role: 'ANONIMO' });
    renderWithRouter(['/login']);
    expect(screen.getAllByText(/Login/i)[0]).toBeInTheDocument();
  });

  it('renders the sign-up page when path is /signup', () => {
    useStateContext.mockReturnValue({ token: null, role: 'ANONIMO' });
    renderWithRouter(['/signup']);
    expect(screen.getByText(/Sign up/i)).toBeInTheDocument();
  });

  it('redirects to /login when user is not authenticated and tries to access authenticated routes', async () => {
    useStateContext.mockReturnValue({ token: null, role: 'ANONIMO' });
    renderWithRouter(['/selezioneprofilo']);
    await waitFor(() => expect(screen.getAllByText(/Login/i)[0]).toBeInTheDocument());
  });

  it('renders the customer dashboard when user is a CLIENTE', async () => {
    useStateContext.mockReturnValue({ token: 'test_token', role: 'CLIENTE' });
    renderWithRouter(['/dashboardcliente']);
    await waitFor(() => {
        expect(screen.getAllByText(/Cliente/i)[0]).toBeInTheDocument();
        expect(screen.getAllByText(/Dashboard/i)[0]).toBeInTheDocument();
    });
  });
/*
  it('renders the ristoratore dashboard when user is a RISTORATORE', async () => {
    useStateContext.mockReturnValue({ token: 'test_token', role: 'RISTORATORE' });
    renderWithRouter(['/dashboardristoratore']);
    await waitFor(() => {
        expect(screen.getAllByText(/Dashboard Ristoratore/i)[0]).toBeInTheDocument();
        expect(screen.getAllByText(/Ristoratore/i)[0]).toBeInTheDocument();
    });
  });
*/
  it('renders the 404 page for unknown routes', () => {
    useStateContext.mockReturnValue({ token: null, role: 'ANONIMO' });
    renderWithRouter(['/unknownpath']);
    expect(screen.getByText(/404 - Page Not Found/i)).toBeInTheDocument();
  });
});
