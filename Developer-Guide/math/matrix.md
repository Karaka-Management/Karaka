# Matrix

The `Matrix` class implements matrices of the form `m x n`. 

```php
$matrix = new Matrix();
$matrix->setMatrix([
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
);
```

The implementation implements `ArrayAccess` for direct access and an `Iterator` for iteration.

```php
$matrix[0][2]; // = 3
```

```php
foreach($matrix as $rowId => $row) {
    foreach($row as $columnId => $value) {
        ...
    }
}
```

## Addition

The matrix addition supports matrix and scalar addition. The scalar addition adds a scalar to every element in the matrix.

```php
$matrix->add(4);
```

The matrix addition requires both matrices to have the same dimensions and adds every index to the same index in the base matrix.

```php
$matrix->add($matrixB);
```

## Subtraction

The matrix subtraction supports matrix and scalar subtraction. The scalar subtraction subtracts a scalar to every element in the matrix.

```php
$matrix->sub(4);
```

The matrix subtraction requires both matrices to have the same dimensions and subtracts every index to the same index in the base matrix.

```php
$matrix->sub($matrixB);
```

## Multiplication

The matrix multiplication supports matrix/vector and scalar multiplication. The scalar multiplication subtracts a scalar to every element in the matrix.

```php
$matrix->mult(4);
```

The matrix multiplication performs a normal matrix multiplication.

```php
$matrix->mult($matrixB);
```

## Solve

In order to solve `A x = b` the matrix implements `solve` which automatically selects an appropriate algorithm (LU or QR decomposition) to solve the equation.

```php
$matrix->solve($matrixB);
```

## Inverse

The inverse calculates the inverse if possible.

```php
$matrix->inverse();
```

## Transpose

The transpose function transposes the matrix.

```php
$matrix->transpose();
```

## Determinant

The determinant of a matrix is calculated via the `det` function.

```php
$matrix->det();
```

## Diagonalize

The diagonalize function diagonalizes the matrix if possible.

```php
$matrix->diagonalize();
```

## Triangulize

### Upper Triangular

The upper triangular of a matrix can be created via the `upperTriangular` function.

```php
$matrix->upperTriangular();
```

### Lower Triangular

The lower triangular of a matrix can be created via the `lowerTriangular` function.

```php
$matrix->lowerTriangular();
```

## Vector

The `Vector` class is a extension of the `Matrix` class `m x 1` and implements vectors.

## Identity Matrix

The `IdentityMatrix` class is a extension of the `Matrix` class and implements the identity matrix `m x n`.