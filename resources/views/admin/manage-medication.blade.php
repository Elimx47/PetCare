<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Pet Medication Inventory</h1>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
                                <i class="bi bi-plus-circle me-2"></i>Add New Medication
                            </button>
                            <div class="input-group w-50">
                                <input type="text" class="form-control" placeholder="Search medications...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Medication Name</th>
                                        <th>Type</th>
                                        <th>Current Stock</th>
                                        <th>Unit</th>
                                        <th>Reorder Level</th>
                                        <th>Expiry Date</th>
                                        <th class="text-center">Actions</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample data -->
                                    <tr>
                                        <td>Heartgard Plus</td>
                                        <td>Heartworm preventative</td>
                                        <td>150</td>
                                        <td>Tablets</td>
                                        <td>50</td>
                                        <td>2025-12-31</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" title="Adjust Stock">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">In Stock</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin</td>
                                        <td>Antibiotic</td>
                                        <td>30</td>
                                        <td>Bottles</td>
                                        <td>40</td>
                                        <td>2024-10-15</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" title="Adjust Stock">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning">Low Stock</span>
                                        </td>
                                    </tr>
                                    <!-- Additional Medications -->
                                    <tr>
                                        <td>Bravecto</td>
                                        <td>Flea & Tick Treatment</td>
                                        <td>75</td>
                                        <td>Chews</td>
                                        <td>30</td>
                                        <td>2026-03-22</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" title="Adjust Stock">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">In Stock</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Frontline Plus</td>
                                        <td>Flea & Tick Treatment</td>
                                        <td>20</td>
                                        <td>Vials</td>
                                        <td>25</td>
                                        <td>2024-08-10</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" title="Adjust Stock">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning">Low Stock</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Doxycycline</td>
                                        <td>Antibiotic</td>
                                        <td>60</td>
                                        <td>Capsules</td>
                                        <td>20</td>
                                        <td>2025-01-15</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" title="Adjust Stock">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">In Stock</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Prednisone</td>
                                        <td>Anti-inflammatory</td>
                                        <td>40</td>
                                        <td>Tablets</td>
                                        <td>10</td>
                                        <td>2025-06-20</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm" title="Adjust Stock">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning">Low Stock</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Medication Modal -->
    <div class="modal fade" id="addMedicationModal" tabindex="-1" aria-labelledby="addMedicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicationModalLabel">Add New Medication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="medicationName" class="form-label">Medication Name</label>
                            <input type="text" class="form-control" id="medicationName" required>
                        </div>
                        <div class="mb-3">
                            <label for="medicationType" class="form-label">Type</label>
                            <input type="text" class="form-control" id="medicationType" required>
                        </div>
                        <div class="mb-3">
                            <label for="initialStock" class="form-label">Initial Stock</label>
                            <input type="number" class="form-control" id="initialStock" required>
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="unit" required>
                        </div>
                        <div class="mb-3">
                            <label for="reorderLevel" class="form-label">Reorder Level</label>
                            <input type="number" class="form-control" id="reorderLevel" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiryDate" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiryDate" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add Medication</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>