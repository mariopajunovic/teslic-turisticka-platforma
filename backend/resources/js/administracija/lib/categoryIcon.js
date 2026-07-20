import {
    Hammer, Utensils, Wrench, Trees, Landmark, BedDouble, CalendarDays,
    BookOpen, Users, Camera, Star, Briefcase, Building2, Megaphone, Leaf,
    Mountain, Waves, PartyPopper, Tag, MapPin, Store, Newspaper, Ticket,
    Sparkles, Coffee, ShoppingBag,
} from 'lucide-vue-next';

const map = {
    hammer: Hammer, zanat: Hammer,
    utensils: Utensils, hrana: Utensils, coffee: Coffee,
    wrench: Wrench, usluge: Wrench,
    trees: Trees, priroda: Trees, leaf: Leaf,
    landmark: Landmark, kultura: Landmark,
    'bed-double': BedDouble, smjestaj: BedDouble,
    'calendar-days': CalendarDays, dogadjaj: CalendarDays,
    'book-open': BookOpen,
    users: Users, camera: Camera, star: Star,
    briefcase: Briefcase, 'building-2': Building2, megaphone: Megaphone,
    mountain: Mountain, waves: Waves, 'party-popper': PartyPopper,
    'map-pin': MapPin, store: Store, newspaper: Newspaper,
    ticket: Ticket, sparkles: Sparkles, 'shopping-bag': ShoppingBag,
};

export function resolveCategoryIcon(name) {
    return map[name] || Tag;
}

export const ICON_CHOICES = [
    'utensils', 'hammer', 'wrench', 'store', 'shopping-bag', 'coffee',
    'trees', 'leaf', 'mountain', 'waves', 'landmark', 'bed-double',
    'calendar-days', 'party-popper', 'ticket', 'book-open', 'users',
    'camera', 'star', 'sparkles', 'briefcase', 'building-2', 'megaphone',
    'map-pin', 'newspaper', 'tag',
];

export const TIP_BOJE = {
    domace: '#2271B1',
    turizam: '#0A7D54',
    dogadjaj: '#B26A00',
    price: '#D63638',
    oglasi: '#7A3EA1',
};
