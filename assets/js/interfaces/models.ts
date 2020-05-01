export interface Movie {
    id: number,
    title: string,
    genre: string
    showtimes: Array<Showtime>
}

export interface Showtime {
    showtime: string
}
